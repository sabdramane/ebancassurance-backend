<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\PreContrat;
use App\Models\QuestionnaireMedical;
use App\Models\PreContratQuestionnaire;
use App\Models\ContratQuestionnaire;
use App\Models\Produit;
use App\Models\Agence;
use App\Models\Beneficiaire;
use DB;
use PDF;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;


class ContratController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contrats = DB::table('contrats')
                        ->select('contrats.id','contrats.numprojet','contrats.dateeffet','contrats.dateeche','contrats.montantpret','contrats.primetotale','contrats.montantpret',
                                'contrats.duree_pret','contrats.differe','contrats.etat','contrats.banque_id','contrats.agence_id','contrats.numdossier',
                                'clients.nom','clients.prenom','clients.numcompte','clients.codeagence','clients.clerib')
                        ->join('clients', 'clients.id', '=', 'contrats.client_id')
                        ->orderBy('id','desc')
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

        
        
        $agence = Agence::find($precontrat->agence_id);

        $codeproduit = $produit->codeprod;
        $nbcontrat = 0;
        $numprojet = 0;
        //récuperation des contrats en fonction du statut enregistré ou validé
        $contrats = Contrat::where('produit_id',$precontrat->produit_id)
                            ->where('agence_id',$precontrat->agence_id)
                            ->where('etat',$request->statut)
                            ->get();

        //Détermination du dernier numéro de contrats
        if($contrats == null){
            $nbcontrat = 1;
        }else{
            $nbcontrat = $contrats->count()+1;
        }

        //Formatage du numéro de contrat
        if($request->statut == "enregistré")
        {
            //s'il s'agit de la validation du contrat, le numéro de contrat est formaté suivant le format codeproduit+numéro, ex:205000001
                if ($nbcontrat<10) {
                    $numprojet = "-00000".$nbcontrat;
                }else if ($nbcontrat < 100) {
                    $numprojet = "-0000".$nbcontrat;
                } else if ($nbcontrat < 1000){
                    $numprojet = "-000".$nbcontrat;
                }else if ($nbcontrat < 10000){
                    $numprojet = "-00".$nbcontrat;
                }else if ($nbcontrat < 100000){
                    $numprojet = "-0".$nbcontrat;
                }else if ($nbcontrat < 1000000){
                    $numprojet = "-".$nbcontrat;
                }
        }else{
            //s'il s'agit de la validation du contrat, le numéro de contrat est formaté suivant le format codeproduit+numéro, ex:205000001
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
        }

        
        $contrat = new contrat();
        $contrat->numprojet = $numprojet;
        $contrat->type_pret = $precontrat->type_pret;
        $contrat->numdossier = $precontrat->numdossier;
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
        $contrat->banque_id = $agence->banque_id;
        $contrat->agence_id = $agence->id;
        $contrat->produit_id =  $precontrat->produit_id;
        $contrat->contrat_travail = $precontrat->contrat_travail;
        $contrat->client_id = $precontrat->client_id;
        $contrat->beneficiaire_id =$precontrat->beneficiaire_id;
        $contrat->contrat_travail =$precontrat->contrat_travail;
        $contrat->contrat_travail_ext = $precontrat->contrat_travail_ext;
        $contrat->employeur = $precontrat->employeur;
        $contrat->precontrat_id = $precontrat->id;
        $contrat->user_id = Auth::user()->id;
        $contrat->etat = $request->statut;
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
            'contrat'=>$contrat->load(['client','banque','agence']),
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
        $contrat = Contrat::find($id);

        $datenaissance =Carbon::createFromFormat('d/m/Y', $contrat->client->dateNaissance);
      // $datenaissance = new DateTime("17/12/2024");
        
       // return "OK".$datenaissance->format('Y');
        $datejour = new DateTime();
        $annenaissance = $datenaissance->format('Y');
        $annejour =  $datejour->format('Y');
        $age = $annejour - $annenaissance;//l'age du client
        //Determinons la durée du contrats
        $duree_contrat = $request->duree;
        $taux_differe_appl = 0;
       
        $agence = Agence::find($contrat->agence_id);

        //Déterminons le code tarif Flex à appliquer 
        $banque_garantie_tarif_flex = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',1)
                                                ->first();
        //Déterminons le code tarif prévoyance à appliquer
        $banque_garantie_tarif_prevoyance = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',5)
                                                ->first();
        //Déterminons le code tarif Perte emploi à appliquer
        $banque_garantie_tarif_perte_emploi = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',4)
                                                ->first();

        //Déterminons le code tarif BEOGO à appliquer
        $banque_garantie_tarif_beogo = DB::table('banque_garantie_tarifs')
                                            ->select('banque_garantie_tarifs.*')
                                            ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
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
        $prime_nette_perte_emploi = 0;

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

        if ($request->type_pret =="DECOUVERT") {
            $prime_nette_flex = $request->montantpret * (round($taux_prevoyance->taux,5)+round($taux_differe_appl,5));
        }else{
            $prime_nette_flex = $request->montantpret * ($taux_flex->taux+round($taux_differe_appl,5))*$taux_fractionnement;
        }

        $prime_nette_prevoyance = $request->capitalprevoyance * round($taux_prevoyance->taux,5);
        
        if($request->perteEmploi == 1){
            $prime_nette_perte_emploi = $request->montant_traite *$taux_perte_emploi->taux;
        }

        if ($request->beogo == 1) {
           $prime_nette_beogo = 1000000*$taux_beogo->taux;
        }
        $cout_police = 1000;

        $prime_totale = $prime_nette_flex+$prime_nette_prevoyance+$prime_nette_perte_emploi+$prime_nette_beogo+$cout_police;
        


        if ($contrat != null) {
            $contrat->type_pret = $request->type_pret;
            $contrat->numdossier = $request->numero_dossier;
            $contrat->dateeche = $request->dateeche;
            $contrat->dateeffet = $request->dateeffet;
            $contrat->periodicite = $request->periodicite;
            $contrat->differe = $request->duree_differe;
            $contrat->duree_amort = $duree_contrat;
            $contrat->duree_pret = $request->duree;
            $contrat->montantpret = $request->montantpret;
            $contrat->capitalprevoyance = $request->capitalprevoyance;
            $contrat->montant_traite = $request->montant_traite;
            $contrat->beogo = $request->beogo;
            $contrat->prime_nette_flex = round($prime_nette_flex,0);
            $contrat->prime_nette_prevoyance = $prime_nette_prevoyance;
            $contrat->prime_perte_emploi = $prime_nette_perte_emploi;
            $contrat->prime_beogo = $prime_nette_beogo;
            $contrat->primetotale = round($prime_totale,0);
            $contrat->cout_police = $cout_police;
    
            if ($request->beneficiaire != "") {
                $beneficiaire = Beneficiaire::find($contrat->beneficiaire_id);
                if($beneficiaire == null){
                    $beneficiaire = new Beneficiaire();
                }
                $beneficiaire->beneficiaire_nom = $request->beneficiaire;
                $beneficiaire->telephone = $request->contact_beneficiaire;
                $beneficiaire->save() ;
                $contrat->beneficiaire_id = $beneficiaire->id;
            }
    
            if ($files = $request->file('contrat_travail')) {
                $extension_fichier = $request->contrat_travail->getClientOriginalExtension();
                $nom_fichier = $request->contrat_travail->hashName();
                $fichier = $request->contrat_travail->move("storage/imports/contrat_travail/", $nom_fichier);
                $contrat->contrat_travail = $nom_fichier;
                $contrat->contrat_travail_ext = $extension_fichier;
                $contrat->employeur = $request->employeur;
            }
            //$contrat->user_id = Auth::user()->id;
            $contrat->save();
        }

        $contrat_quest_tailles = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$contrat->id)
                        ->where('questionnaire_medicals.codequestion',"taille")
                        ->first();
        $contrat_quest_poids = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$contrat->id)
                        ->where('questionnaire_medicals.codequestion',"poids")
                        ->first();

        $contrat_quests = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','questionnaire_medicals.codequestion','contrat_questionnaires.valeur','contrat_questionnaires.motif','contrat_questionnaires.datesurvenance','questionnaire_medicals.libelle')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$contrat->id)
                        ->where('questionnaire_medicals.codequestion','!=',"poids")
                        ->where('questionnaire_medicals.codequestion','!=',"taille")
                        ->get();

        return response()->json([
            "success" => true,
            "contrat_id" =>$contrat->id,
            "taille"=> $contrat_quest_tailles,
            "poids" => $contrat_quest_poids,
            "contrat_questionnaires" => $contrat_quests
        ]);
    }

    public function updateContrat(Request $request)
    {
        $contrat = Contrat::find($request->id);

        $datenaissance =Carbon::createFromFormat('d/m/Y', $contrat->client->dateNaissance);
      // $datenaissance = new DateTime("17/12/2024");
        
       // return "OK".$datenaissance->format('Y');
        $datejour = new DateTime();
        $annenaissance = $datenaissance->format('Y');
        $annejour =  $datejour->format('Y');
        $age = $annejour - $annenaissance;//l'age du client
        //Determinons la durée du contrats
        $duree_contrat = $request->duree;
        $taux_differe_appl = 0;
       
        $agence = Agence::find($contrat->agence_id);

        //Déterminons le code tarif Flex à appliquer 
        $banque_garantie_tarif_flex = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',1)
                                                ->first();
        //Déterminons le code tarif prévoyance à appliquer
        $banque_garantie_tarif_prevoyance = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',5)
                                                ->first();
        //Déterminons le code tarif Perte emploi à appliquer
        $banque_garantie_tarif_perte_emploi = DB::table('banque_garantie_tarifs')
                                                ->select('banque_garantie_tarifs.*')
                                                ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
                                                ->where('banque_garantie_tarifs.produit_id',$request->produit_id)
                                                ->where('banque_garantie_tarifs.garantie_id',4)
                                                ->first();

        //Déterminons le code tarif BEOGO à appliquer
        $banque_garantie_tarif_beogo = DB::table('banque_garantie_tarifs')
                                            ->select('banque_garantie_tarifs.*')
                                            ->where('banque_garantie_tarifs.banque_id',$agence->banque_id)
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
        $prime_nette_perte_emploi = 0;

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

        if ($request->type_pret =="DECOUVERT") {
            $prime_nette_flex = $request->montantpret * (round($taux_prevoyance->taux,5)+round($taux_differe_appl,5));
        }else{
            $prime_nette_flex = $request->montantpret * ($taux_flex->taux+round($taux_differe_appl,5))*$taux_fractionnement;
        }

        $prime_nette_prevoyance = $request->capitalprevoyance * round($taux_prevoyance->taux,5);
        
        if($request->perteEmploi == 1){
            $prime_nette_perte_emploi = $request->montant_traite *$taux_perte_emploi->taux;
        }

        if ($request->beogo == 1) {
           $prime_nette_beogo = 1000000*$taux_beogo->taux;
        }
        $cout_police = 1000;

        $prime_totale = $prime_nette_flex+$prime_nette_prevoyance+$prime_nette_perte_emploi+$prime_nette_beogo+$cout_police;
        


        if ($contrat != null) {
            $contrat->type_pret = $request->type_pret;
            $contrat->numdossier = $request->numero_dossier;
            $contrat->dateeche = $request->dateeche;
            $contrat->dateeffet = $request->dateeffet;
            $contrat->periodicite = $request->periodicite;
            $contrat->differe = $request->duree_differe;
            $contrat->duree_amort = $duree_contrat;
            $contrat->duree_pret = $request->duree;
            $contrat->montantpret = $request->montantpret;
            $contrat->capitalprevoyance = $request->capitalprevoyance;
            $contrat->montant_traite = $request->montant_traite;
            $contrat->beogo = $request->beogo;
            $contrat->prime_nette_flex = round($prime_nette_flex,0);
            $contrat->prime_nette_prevoyance = $prime_nette_prevoyance;
            $contrat->prime_perte_emploi = $prime_nette_perte_emploi;
            $contrat->prime_beogo = $prime_nette_beogo;
            $contrat->primetotale = round($prime_totale,0);
            $contrat->cout_police = $cout_police;
    
            if ($request->beneficiaire != "") {
                $beneficiaire = Beneficiaire::find($contrat->beneficiaire_id);
                if($beneficiaire == null){
                    $beneficiaire = new Beneficiaire();
                }
                $beneficiaire->beneficiaire_nom = $request->beneficiaire;
                $beneficiaire->telephone = $request->contact_beneficiaire;
                $beneficiaire->save() ;
                $contrat->beneficiaire_id = $beneficiaire->id;
            }
    
            if ($files = $request->file('contrat_travail')) {
                $extension_fichier = $request->contrat_travail->getClientOriginalExtension();
                $nom_fichier = $request->contrat_travail->hashName();
                $fichier = $request->contrat_travail->move("storage/imports/contrat_travail/", $nom_fichier);
                $contrat->contrat_travail = $nom_fichier;
                $contrat->contrat_travail_ext = $extension_fichier;
                $contrat->employeur = $request->employeur;
            }
            //$contrat->user_id = Auth::user()->id;
            $contrat->save();
        }

        $contrat_quest_tailles = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$contrat->id)
                        ->where('questionnaire_medicals.codequestion',"taille")
                        ->first();
        $contrat_quest_poids = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','contrat_questionnaires.valeur','contrat_questionnaires.motif')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$contrat->id)
                        ->where('questionnaire_medicals.codequestion',"poids")
                        ->first();

        $contrat_quests = DB::table('contrat_questionnaires')
                        ->select('contrat_questionnaires.id','questionnaire_medicals.codequestion','contrat_questionnaires.valeur','contrat_questionnaires.motif','contrat_questionnaires.datesurvenance','questionnaire_medicals.libelle')
                        ->join('questionnaire_medicals', 'questionnaire_medicals.id', '=', 'contrat_questionnaires.questionnaire_medical_id')
                        ->where('contrat_questionnaires.contrat_id',$contrat->id)
                        ->where('questionnaire_medicals.codequestion','!=',"poids")
                        ->where('questionnaire_medicals.codequestion','!=',"taille")
                        ->get();

        return response()->json([
            "success" => true,
            "contrat_id" =>$contrat->id,
            "taille"=> $contrat_quest_tailles,
            "poids" => $contrat_quest_poids,
            "contrat_questionnaires" => $contrat_quests
        ]);
    }

    public function storeFinalStep(Request $request)  
    {
        $contrat = Contrat::find($request->contrat_id);
        $produit = Produit::find($contrat->produit_id);

        $agence = Agence::find($contrat->agence_id);

        $codeproduit = $produit->codeprod;
        $nbcontrat = 0;
        $numprojet = 0;
        //récuperation des contrats en fonction du statut enregistré ou validé
        $contrats = Contrat::where('produit_id',$contrat->produit_id)
                            ->where('agence_id',$contrat->agence_id)
                            ->where('etat',$request->statut)
                            ->get();

        //Détermination du dernier numéro de contrats
        if($contrats == null){
            $nbcontrat = 1;
        }else{
            $nbcontrat = $contrats->count()+1;
        }

        //Formatage du numéro de contrat
        if($request->statut != "enregistré")
        {
           //s'il s'agit de la validation du contrat, le numéro de contrat est formaté suivant le format codeproduit+numéro, ex:205000001
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

            $contrat->numprojet = $numprojet;
            $contrat->etat = "validé";
            $contrat->save();
        }
        return response()->json([
            "success" => true
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
