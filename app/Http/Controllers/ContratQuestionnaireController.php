<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\ContratQuestionnaire;
use App\Models\QuestionnaireMedical;


class ContratQuestionnaireController extends Controller
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
        if($request->taille != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"taille")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->taille;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }
        if($request->poids != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"poids")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->poids;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }
        if($request->arret_travail != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"arret_travail")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->arret_travail;
            $contrat_questionnaire->motif = $request->motif_arret_travail;
            $contrat_questionnaire->datesurvenance = $request->datesurvenancearret_travail;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }
        if($request->accident != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"accident")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->accident;
            $contrat_questionnaire->motif = $request->motif_accident;
            $contrat_questionnaire->datesurvenance = $request->datesurvenanceaccident;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }

        if($request->maladie_infirmite != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"maladie_infirmite")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->maladie_infirmite;
            $contrat_questionnaire->motif = $request->motif_maladie_infirmite;
            $contrat_questionnaire->datesurvenance = $request->datesurvenancemaladie_infirmite;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }

        if($request->traitement_piqure != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"traitement_piqure")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->traitement_piqure;
            $contrat_questionnaire->motif = $request->motif_traitement_piqure;
            $contrat_questionnaire->datesurvenance = $request->datesurvenancetraitement_piqure;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }
        if($request->perfusion != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"perfusion")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->perfusion;
            $contrat_questionnaire->motif = $request->motif_perfusion;
            $contrat_questionnaire->datesurvenance = $request->datesurvenanceperfusion;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }
        
        if($request->hepatite_sida != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"hepatite_sida")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->hepatite_sida;
            $contrat_questionnaire->motif = $request->motif_hepatite_sida;
            $contrat_questionnaire->datesurvenance = $request->datesurvenancehepatite_sida;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }

        if($request->intervention != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"intervention")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->intervention;
            $contrat_questionnaire->motif = $request->motif_intervention;
            $contrat_questionnaire->datesurvenance = $request->datesurvenanceintervention;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }
        if($request->meningite_maladie != ''){
            $questionnaire = QuestionnaireMedical::where('codequestion',"meningite_maladie")
                                                    ->first();
            $contrat_questionnaire = ContratQuestionnaire::where('questionnaire_medical_id',$questionnaire->id)
                                                    ->where('contrat_id',$request->contrat_id)
                                                    ->first();
            if($contrat_questionnaire == null){
                $contrat_questionnaire = new ContratQuestionnaire();
            }
            $contrat_questionnaire->valeur = $request->meningite_maladie;
            $contrat_questionnaire->motif = $request->motif_meningite_maladie;
            $contrat_questionnaire->datesurvenance = $request->datesurvenancemeningite_maladie;
            $contrat_questionnaire->contrat_id = $request->contrat_id;
            $contrat_questionnaire->questionnaire_medical_id = $questionnaire->id;
            $contrat_questionnaire->save();
        }

        $contrat = Contrat::find($request->contrat_id);
        return response()->json([
            "success" => true,
            "contrat" =>$contrat->load(['client','beneficiaire'])
        ]);

        
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
