<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use App\Models\Simulation;

class SimulationController extends Controller
{
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
    public function store(Request $request)
    {
        //Déterminons l'age du client
        $datenaissance = explode("/",$request->datenaissance);
        $datenaissance = new DateTime($datenaissance[2]."/".$datenaissance[1]."/".$datenaissance[0]);

        
        $datejour = new DateTime();
        $annenaissance = $datenaissance->format('Y');
        $annejour =  $datejour->format('Y');
        $age = $annejour - $annenaissance;//l'age du client
        //Determinons la durée du contrats
        $duree_contrat = $request->duree;
        $taux_differe_appl = 0;
       
        //Déterminons le code tarif Flex à appliquer 
        $banque_garantie_tarif_flex = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$request->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',1)
                                                ->first();
        //Déterminons le code tarif prévoyance à appliquer
        $banque_garantie_tarif_prevoyance = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$request->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',5)
                                                ->first();
        //Déterminons le code tarif Perte emploi à appliquer
        $banque_garantie_tarif_perte_emploi = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$request->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',4)
                                                ->first();

        //Déterminons le code tarif BEOGO à appliquer
        $banque_garantie_tarif_beogo = DB::table('banque_garantie_tarifs')
                                            ->select('banque_garantie_tarifs.*')
                                            ->where('banque_garantie_tarifs.banque_id',$request->banque_id)
                                            ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                            ->where('banque_garantie_tarifs.garantie_id',7)
                                            ->first();

         if($request->duree_differe != 0){
            $duree_contrat -= $request->duree_differe;
             //Déterminons le taux tarif prévoyance à appliquer
            $taux_differe = DB::table('tableau_tarifs')
                            ->select('tableau_tarifs.*')
                            ->where('tableau_tarifs.age',$age)
                            ->where('tableau_tarifs.tarif_id',$banque_garantie_tarif_prevoyance->tarif_id)
                            ->where('duree_min','<=',$request->duree_differe)
                            ->where('duree_max','>=',$request->duree_differe)
                            ->first();
            $taux_differe_appl = $taux_differe->taux;
        }
        //Déterminons le taux tarif Flex à appliquer
        $taux_flex = DB::table('tableau_tarifs')
                    ->select('tableau_tarifs.*')
                    ->where('tableau_tarifs.age',$age)
                    ->where('tableau_tarifs.tarif_id',$banque_garantie_tarif_flex->tarif_id)
                    ->where('duree_min','<=',$duree_contrat)
                    ->where('duree_max','>=',$duree_contrat)
                    ->first();
       
         //Déterminons le taux tarif prévoyance à appliquer
         $taux_prevoyance = DB::table('tableau_tarifs')
                            ->select('tableau_tarifs.taux')
                            ->where('tableau_tarifs.age',$age)
                            ->where('tableau_tarifs.tarif_id',$banque_garantie_tarif_prevoyance->tarif_id)
                            ->where('duree_min','<=',$request->duree)
                            ->where('duree_max','>=',$request->duree)
                            ->first();
        //Déterminons le taux tarif perte emploi à appliquer
        $taux_perte_emploi = DB::table('tableau_tarifs')
                            ->select('tableau_tarifs.taux')
                            ->where('tableau_tarifs.tarif_id',$banque_garantie_tarif_perte_emploi->tarif_id)
                            ->where('duree_min','<=',$request->duree)
                            ->where('duree_max','>=',$request->duree)
                            ->first();
        //Déterminons le taux tarif beogo à appliquer
        $taux_beogo = DB::table('tableau_tarifs')
                            ->select('tableau_tarifs.taux')
                            ->where('tableau_tarifs.age',$age)
                            ->where('tableau_tarifs.tarif_id',$banque_garantie_tarif_beogo->tarif_id)
                            ->first();
        $prime_nette_beogo = 0;

        $taux_fractionnement = 1;
        if($request->periodicite == "Mensuelle"){
            $taux_fractionnement = $taux_fractionnement + 0;
        }else if($request->periodicite == "Trimestrielle"){
            $taux_fractionnement = $taux_fractionnement + 0.03;
        }else if($request->periodicite == "Semestrielle"){
            $taux_fractionnement = $taux_fractionnement + 0.04;
        }else if($request->periodicite == "Annuelle"){
            $taux_fractionnement = $taux_fractionnement + 0.04;
        }
        $prime_nette_flex = $request->montantpret * ($taux_flex->taux+round($taux_differe_appl,5))*$taux_fractionnement;
        $prime_nette_prevoyance = $request->capitalprevoyance * round($taux_prevoyance->taux,5);
        $prime_nette_perte_emploi = $request->montant_traite *$taux_perte_emploi->taux;
        if ($request->beogo == 1) {
           $prime_nette_beogo = 1000000*$taux_beogo->taux;
        }
        $cout_police = 1000;

        $prime_totale = $prime_nette_flex+$prime_nette_prevoyance+$prime_nette_perte_emploi+$prime_nette_beogo+$cout_police;

        
        $simulation = new Simulation();
        $simulation->datenaissance = $datenaissance;
        $simulation->duree_amort = $duree_contrat;
        $simulation->duree_pret = $request->duree;
        $simulation->periodicite = $request->periodicite;
        $simulation->differe = $request->duree_differe;
        $simulation->montantpret = $request->montantpret;
        $simulation->capitalprevoyance = $request->capitalprevoyance;
        $simulation->montant_traite = $request->montant_traite;
        $simulation->beogo = $request->beogo;
        $simulation->prime_nette_flex = $prime_nette_flex;
        $simulation->prime_nette_prevoyance = $prime_nette_prevoyance;
        $simulation->prime_perte_emploi = $prime_nette_perte_emploi;
        $simulation->prime_beogo = $prime_nette_beogo;
        $simulation->primetotale = $prime_totale;
        $simulation->cout_police = $cout_police;
        $simulation->banque_id = $request->banque_id;
        //$simulation->agence_id = $request->agence_id;
        $simulation->produit_id = $request->produit_id;
        $simulation->save();
      
        return  $simulation;

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
