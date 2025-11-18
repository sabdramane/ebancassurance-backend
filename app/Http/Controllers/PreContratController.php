<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\contrat\ContratPostRequest;
use DB;
use DateTime;
use App\Models\PreContrat;
use App\Models\Beneficiaire;
use App\Models\Client;
use App\Models\AgenceUser;
use App\Models\Agence;
use Auth;
use Carbon\Carbon;


class PreContratController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContratPostRequest $request)
    {

        $datenaissance = Carbon::createFromFormat('d/m/Y', $request->datenaissance);
        // $datenaissance = new DateTime("17/12/2024");

        // return "OK".$datenaissance->format('Y');
        $datejour = new DateTime();
        $annenaissance = $datenaissance->format('Y');
        $annejour = $datejour->format('Y');
        $age = $annejour - $annenaissance;//l'age du client
        //Determinons la durée du contrats
        $duree_contrat = $request->duree;
        $taux_differe_appl = 0;
        $agence_user = AgenceUser::where('user_id', Auth::user()->id)
            ->whereNull('date_desaffectation')->first();
        $agence = Agence::find($agence_user->agence_id);

        //Déterminons le code tarif Flex à appliquer 
        $banque_garantie_tarif_flex = DB::table('banque_garantie_tarifs')
            ->select('banque_garantie_tarifs.*')
            ->where('banque_garantie_tarifs.banque_id', $agence->banque_id)
            ->where('banque_garantie_tarifs.produit_id', $request->produit_id)
            ->where('banque_garantie_tarifs.garantie_id', 1)
            ->first();
        //Déterminons le code tarif prévoyance à appliquer
        $banque_garantie_tarif_prevoyance = DB::table('banque_garantie_tarifs')
            ->select('banque_garantie_tarifs.*')
            ->where('banque_garantie_tarifs.banque_id', $agence->banque_id)
            ->where('banque_garantie_tarifs.produit_id', $request->produit_id)
            ->where('banque_garantie_tarifs.garantie_id', 5)
            ->first();
        //Déterminons le code tarif Perte emploi à appliquer
        $banque_garantie_tarif_perte_emploi = DB::table('banque_garantie_tarifs')
            ->select('banque_garantie_tarifs.*')
            ->where('banque_garantie_tarifs.banque_id', $agence->banque_id)
            ->where('banque_garantie_tarifs.produit_id', $request->produit_id)
            ->where('banque_garantie_tarifs.garantie_id', 4)
            ->first();

        //Déterminons le code tarif BEOGO à appliquer
        $banque_garantie_tarif_beogo = DB::table('banque_garantie_tarifs')
            ->select('banque_garantie_tarifs.*')
            ->where('banque_garantie_tarifs.banque_id', $agence->banque_id)
            ->where('banque_garantie_tarifs.produit_id', $request->produit_id)
            ->where('banque_garantie_tarifs.garantie_id', 7)
            ->first();

        if ($request->duree_differe != 0) {
            $duree_contrat -= $request->duree_differe;
            //Déterminons le taux tarif prévoyance à appliquer
            $taux_differe = DB::table('tableau_tarifs')
                ->select('tableau_tarifs.*')
                ->where('tableau_tarifs.age', $age)
                ->where('tableau_tarifs.tarif_id', $banque_garantie_tarif_prevoyance->tarif_id)
                ->where('duree_min', '<=', $request->duree_differe)
                ->where('duree_max', '>=', $request->duree_differe)
                ->first();
            $taux_differe_appl = $taux_differe->taux;
        }
        //Déterminons le taux tarif Flex à appliquer
        $taux_flex = DB::table('tableau_tarifs')
            ->select('tableau_tarifs.*')
            ->where('tableau_tarifs.age', $age)
            ->where('tableau_tarifs.tarif_id', $banque_garantie_tarif_flex->tarif_id)
            ->where('duree_min', '<=', $duree_contrat)
            ->where('duree_max', '>=', $duree_contrat)
            ->first();

        //Déterminons le taux tarif prévoyance à appliquer
        $taux_prevoyance = DB::table('tableau_tarifs')
            ->select('tableau_tarifs.taux')
            ->where('tableau_tarifs.age', $age)
            ->where('tableau_tarifs.tarif_id', $banque_garantie_tarif_prevoyance->tarif_id)
            ->where('duree_min', '<=', $request->duree)
            ->where('duree_max', '>=', $request->duree)
            ->first();
        //Déterminons le taux tarif perte emploi à appliquer
        $taux_perte_emploi = DB::table('tableau_tarifs')
            ->select('tableau_tarifs.taux')
            ->where('tableau_tarifs.tarif_id', $banque_garantie_tarif_perte_emploi->tarif_id)
            ->where('duree_min', '<=', $request->duree)
            ->where('duree_max', '>=', $request->duree)
            ->first();
        //Déterminons le taux tarif beogo à appliquer
        $taux_beogo = DB::table('tableau_tarifs')
            ->select('tableau_tarifs.taux')
            ->where('tableau_tarifs.age', $age)
            ->where('tableau_tarifs.tarif_id', $banque_garantie_tarif_beogo->tarif_id)
            ->first();
        $prime_nette_beogo = 0;
        $prime_nette_perte_emploi = 0;

        $taux_fractionnement = 1;
        if ($request->periodicite == "Mensuelle") {
            $taux_fractionnement = $taux_fractionnement + 0;
        } else if ($request->periodicite == "Trimestrielle") {
            $taux_fractionnement = $taux_fractionnement + 0.03;
        } else if ($request->periodicite == "Semestrielle") {
            $taux_fractionnement = $taux_fractionnement + 0.04;
        } else if ($request->periodicite == "Annuelle") {
            $taux_fractionnement = $taux_fractionnement + 0.04;
        }

        if ($request->type_pret == "DECOUVERT") {
            $prime_nette_flex = $request->montantpret * (round($taux_prevoyance->taux, 5) + round($taux_differe_appl, 5));
        } else {
            $prime_nette_flex = $request->montantpret * ($taux_flex->taux + round($taux_differe_appl, 5)) * $taux_fractionnement;
        }

        $prime_nette_prevoyance = $request->capitalprevoyance * round($taux_prevoyance->taux, 5);

        if ($request->perteEmploi == 1) {
            $prime_nette_perte_emploi = $request->montant_traite * $taux_perte_emploi->taux;
        }

        if ($request->beogo == 1) {
            $prime_nette_beogo = 1000000 * $taux_beogo->taux;
        }
        $cout_police = 1000;

        $prime_totale = $prime_nette_flex + $prime_nette_prevoyance + $prime_nette_perte_emploi + $prime_nette_beogo + $cout_police;
        $client = Client::find($request->client_id);

        if ($client == null) {
            return response()->json([
                'message' => "Le client n'existe pas"
            ]);
        }

        $precontrat = PreContrat::find($request->precontrat_id);

        if ($precontrat != null) {
            //$precontrat = new PreContrat();
            $precontrat->type_pret = $request->type_pret;
            $precontrat->numdossier = $request->numero_dossier;
            $precontrat->dateeche = $request->dateeche;
            $precontrat->dateeffet = $request->dateeffet;
            $precontrat->datesaisie = $request->datesaisie;
            $precontrat->periodicite = $request->periodicite;
            $precontrat->differe = $request->duree_differe;
            $precontrat->duree_amort = $duree_contrat;
            $precontrat->duree_pret = $request->duree;
            $precontrat->montantpret = $request->montantpret;
            $precontrat->capitalprevoyance = $request->capitalprevoyance;
            $precontrat->montant_traite = $request->montant_traite;
            $precontrat->beogo = $request->beogo;
            $precontrat->prime_nette_flex = round($prime_nette_flex, 0);
            $precontrat->prime_nette_prevoyance = $prime_nette_prevoyance;
            $precontrat->prime_perte_emploi = $prime_nette_perte_emploi;
            $precontrat->prime_beogo = $prime_nette_beogo;
            $precontrat->primetotale = round($prime_totale, 0);
            $precontrat->cout_police = $cout_police;
            $precontrat->banque_id = $agence->banque_id;
            $precontrat->agence_id = $agence->id;
            $precontrat->produit_id = $request->produit_id;
            $precontrat->client_id = $client->id;

            if ($request->beneficiaire != "") {
                $beneficiaire = new Beneficiaire();
                $beneficiaire->beneficiaire_nom = $request->beneficiaire;
                $beneficiaire->telephone = $request->contact_beneficiaire;
                $beneficiaire->save();
                $precontrat->beneficiaire_id = $beneficiaire->id;
            }

            if ($files = $request->file('contrat_travail')) {
                $extension_fichier = $request->contrat_travail->getClientOriginalExtension();
                $nom_fichier = $request->contrat_travail->hashName();
                $fichier = $request->contrat_travail->move("storage/imports/contrat_travail/", $nom_fichier);
                $precontrat->contrat_travail = $nom_fichier;
                $precontrat->contrat_travail_ext = $extension_fichier;
                $precontrat->employeur = $request->employeur;
            }
            $precontrat->user_id = Auth::user()->id;
            $precontrat->save();
        }

        // return response()->json([
        //     "success" => true,
        //     "precontrat" =>$precontrat,
        // ]);
        return $precontrat;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
