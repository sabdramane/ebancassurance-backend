<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\PreContrat;
use App\Models\QuestionnaireMedical;
use App\Models\PreContratQuestionnaire;
use App\Models\ContratQuestionnaire;
use App\Models\Produit;

class ContratController extends Controller
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
        $precontrat = Precontrat::find($request->precontrat_id);
        $produit = Produit::find($precontrat->produit_id);

        $contrats = Contrat::where('produit_id',$precontrat->produit_id)
                            ->where('agence_id',$precontrat->agence_id)
                            ->get();
        
        $codeproduit = $produit->codeprod;
        $nbcontrat = 0;
        $numprojet = 0;
        if($contrats == null){
            $nbcontrat = 1;
        }else{
            $nbcontrat = $contrats->count()+1;
        }

        if ($nbcontrat<10) {
            $numprojet = $codeproduit."00000".$nbcontrat;
        }else if ($nbcontrat < 100) {
            $numprojet = $codeproduit."0000".$nbcontrat;
        } else if ($nbcontrat < 1000){
            $numprojet = $codeproduit."000".$nbcontrat;
        }else if ($nbcontrat < 10000){
            $numprojet = $codeproduit."00".$nbcontrat;
        }else if ($nbcontrat < 100000){
            $numprojet = $codeproduit."0".$nbcontrat;
        }else if ($nbcontrat < 1000000){
            $numprojet = $codeproduit."".$nbcontrat;
        }
        $contrat = new contrat();
        $contrat->numprojet = $numprojet;
        $contrat->type_pret = $precontrat->type_pret;
        $contrat->dateeche = $precontrat->dateeche;
        $contrat->dateeffet = $precontrat->dateeffet;
        $contrat->datesaisie = $precontrat->datesaisie;
        $contrat->periodicite = $precontrat->periodicite;
        $contrat->differe = $precontrat->differe;
        $contrat->duree_amort = $precontrat->duree_amort;
        $contrat->duree_pret = $precontrat->duree_pret;
        $contrat->montantpret = $precontrat->montantpret;
        $contrat->capitalprevoyance = $precontrat->capitalprevoyance;
        $contrat->montant_traite = $precontrat->montant_traite;
        $contrat->beogo = $precontrat->beogo;
        $contrat->prime_nette_flex = $precontrat->prime_nette_flex;
        $contrat->prime_nette_prevoyance = $precontrat->prime_nette_prevoyance;
        $contrat->prime_perte_emploi = $precontrat->prime_perte_emploi;
        $contrat->prime_beogo = $precontrat->prime_beogo;
        $contrat->primetotale = $precontrat->primetotale;
        $contrat->cout_police = $precontrat->cout_police;
        $contrat->banque_id = $precontrat->banque_id;
        //$contrat->agence_id = $request->agence_id;
        $contrat->produit_id =  $precontrat->produit_id;
        $contrat->contrat_travail = $precontrat->contrat_travail;
        $contrat->client_id = $precontrat->client_id;
        $contrat->beneficiaire_id =$precontrat->beneficiaire_id;
        $contrat->contrat_travail =$precontrat->contrat_travail;
        $contrat->contrat_travail_ext = $precontrat->contrat_travail_ext;
        $contrat->employeur = $precontrat->employeur;
        $contrat->save();

        $precontrat_questionnaires = PreContratQuestionnaire::where('precontrat_id',$precontrat->id)
                                                            ->get();
        foreach($precontrat_questionnaires as $precontrat_questionnaire){
            $contrat_questionnaire = new ContratQuestionnaire();
            $contrat_questionnaire->valeur = $precontrat_questionnaire->valeur;
            $contrat_questionnaire->motif = $precontrat_questionnaire->motif;
            $contrat_questionnaire->datesurvenance = $precontrat_questionnaire->datesurvenance;
            $contrat_questionnaire->contrat_id = $contrat->id;
            $contrat_questionnaire->questionnaire_medical_id = $precontrat_questionnaire->questionnaire_medical_id;
            $contrat_questionnaire->save();
        }
        return $contrat;
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
