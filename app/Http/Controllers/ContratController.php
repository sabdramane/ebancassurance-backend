<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\PreContrat;
use App\Models\QuestionnaireMedical;
use App\Models\PreContratQuestionnaire;
use App\Models\ContratQuestionnaire;
use App\Models\Produit;
use DB;
use PDF;


class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contrats = DB::table('contrats')
                        ->select('contrats.id','contrats.numprojet','contrats.dateeffet','contrats.dateeche','contrats.montantpret','contrats.primetotale','contrats.montantpret',
                                'contrats.duree_pret','contrats.differe',
                                'clients.nom','clients.prenom','clients.numcompte','clients.codeagence','clients.clerib')
                        ->join('clients', 'clients.id', '=', 'contrats.client_id')
                        ->get();
        return $contrats;
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
        $contrat->precontrat_id = $precontrat->id;
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

    public function printContrat($id)
    {
        $contrat = Contrat::find($id);
        $contrat_quest_tailles = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$id)
                        ->where('questionnaire_medicals.codequestion',"taille")
                        ->first();
        $contrat_quest_poids = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$id)
                        ->where('questionnaire_medicals.codequestion',"poids")
                        ->first();
        $contrat_quests = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif','questionnaire_medicals.libelle')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$id)
                        ->where('questionnaire_medicals.codequestion','!=',"poids")
                        ->where('questionnaire_medicals.codequestion','!=',"taille")
                        ->get();
        $pdf=PDF::loadView('contrats.contrat_pdf',compact('contrat','contrat_quest_tailles','contrat_quest_poids','contrat_quests'))->setPaper('a4');
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contrat = Contrat::find($id);

        $contrat_quest_tailles = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$id)
                        ->where('questionnaire_medicals.codequestion',"taille")
                        ->first();
        $contrat_quest_poids = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$id)
                        ->where('questionnaire_medicals.codequestion',"poids")
                        ->first();
        $contrat_quests = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif','questionnaire_medicals.libelle')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$id)
                        ->where('questionnaire_medicals.codequestion','!=',"poids")
                        ->where('questionnaire_medicals.codequestion','!=',"taille")
                        ->get();
        $contrat->taille = $contrat_quest_tailles->valeur;
        $contrat->poids = $contrat_quest_poids->valeur;
        return response()->json([
            'contrat'=>$contrat->load(['client']),
            'questionnaires'=>$contrat_quests
        ]);
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
