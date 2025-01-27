<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Contrat;
use App\Models\Rapprochement;
use DB;


class RapprochementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rapprochements = Rapprochement::all();
        return response()->json([
            "success" => true,
            "rapprochements" =>$rapprochements,
        ]);
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
        if ($files = $request->file('fichier_rapprochement')){

            $extension_fichier = $request->fichier_rapprochement->getClientOriginalExtension();
            if(strcmp($extension_fichier,"xlsx") != 0){
                return response()->json([
                    "success" => true,
                    "message" =>"Erreur importation fichier non joint",
                ]);
            }else{
                $montanttotal_fichier = 0;
                $montantrapproche = 0;
                $montant_non_rapproche = 0;
                $nom_fichier = $request->fichier_rapprochement->hashName();
                $fichier = $request->fichier_rapprochement->move("storage/imports/rapprochements/", $nom_fichier);
                $reader = SimpleExcelReader::create($fichier);
                $rows = $reader->getRows();


                $rapprochement = new Rapprochement();
                $rapprochement->libelle = $request->libelle;
                $rapprochement->datedebut = $request->datedebut;
                $rapprochement->datefin = $request->datefin;
                $rapprochement->fichier_rapprochement = $nom_fichier;
                $rapprochement->banque_id = $request->banque_id;
                $rapprochement->save();


                //parcourir chaque ligne du fichier importé
                foreach ($rows as $row) {
                    //formatage du numéro dossier pour supprimer les espaces
                    $numdossier = str_replace(' ', '', $row['DOSSIER']);
                    $montant_paye = str_replace(' ', '', $row['PRIME_ASSU_CORIS']);
                    $datecompt = str_replace(' ', '', $row['DATECOMPTA']);
                    //récupérer le contrat correspondant au numéro de dossier
                    $contrat = Contrat::where('numdossier',$numdossier)
                                        ->where('etat','validé')
                                        ->where('banque_id',$request->banque_id)
                                        ->first();
                    if($contrat != null)
                    {
                        if ($contrat->primetotale == $montant_paye) {
                            $contrat->etat = "payé";
                            $contrat->rapprochement_id = $rapprochement->id;
                            $contrat->montant_paye = $montant_paye;
                            $contrat->datecompt = $datecompt;
                            $contrat->save();
                            $montantrapproche = $montantrapproche + $montant_paye;
                        }
                    }
                    $montanttotal_fichier = $montanttotal_fichier + $montant_paye;
                }
                $montant_non_rapproche = $montanttotal_fichier - $montantrapproche;

                $rapprochement->montanttotal_fichier = $montanttotal_fichier;
                $rapprochement->montantrapproche = $montantrapproche;
                $rapprochement->montant_non_rapproche = $montant_non_rapproche;
                $rapprochement->save();

                return response()->json([
                    "success" => true,
                    "rapprochement" =>$rapprochement,
                ]);
            }
            
        }else{
            return response()->json([
                "success" => true,
                "message" =>"Erreur importation fichier non joint",
            ]);
        }
        
    }

    public function verifRapprochement(Request $request) 
    {
        if ($files = $request->file('fichier_rapprochement')){

            $extension_fichier = $request->fichier_rapprochement->getClientOriginalExtension();
            if(strcmp($extension_fichier,"xlsx") != 0){
                return response()->json([
                    "success" => true,
                    "message" =>"Erreur importation extension du fichier non valide",
                ]);
            }else{
                $montanttotal_fichier = 0;
                $montantrapproche = 0;
                $montant_non_rapproche = 0;

                $fichier = $request->fichier_rapprochement->move("storage/imports/rapprochements/", $request->fichier_rapprochement->hashName());
                $reader = SimpleExcelReader::create($fichier);
                $rows = $reader->getRows();
                //parcourir chaque ligne du fichier importé
                foreach ($rows as $row) {
                    //formatage du numéro dossier pour supprimer les espaces
                    $numdossier = str_replace(' ', '', $row['DOSSIER']);
                    $montant_paye = str_replace(' ', '', $row['PRIME_ASSU_CORIS']);
                    //récupérer le contrat correspondant au numéro de dossier
                    $contrat = Contrat::where('numdossier',$numdossier)
                                        ->where('etat','validé')
                                        ->where('banque_id',$request->banque_id)
                                        ->first();
                    if($contrat != null)
                    {
                        if ($contrat->primetotale == $montant_paye) {
                           $montantrapproche = $montantrapproche + $montant_paye;
                        }
                    }
                    $montanttotal_fichier = $montanttotal_fichier + $montant_paye;
                }
                $montant_non_rapproche = $montanttotal_fichier - $montantrapproche;

                return response()->json([
                    "success" => true,
                    "data" =>[
                        "montant_total_recu" =>$montanttotal_fichier,
                        "montant_rapproche" =>$montantrapproche,
                        "montant_non_rapproche" =>$montant_non_rapproche,
                    ]
                ]);
                
            }
            
        }else{
            return response()->json([
                "success" => true,
                "message" =>"Erreur importation fichier non joint",
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rapprochement = Rapprochement::find($id);
        $contrat_rapproches = DB::table('contrats')
                        ->select('contrats.id','contrats.numprojet','contrats.dateeffet','contrats.dateeche','contrats.montantpret','contrats.primetotale','contrats.montantpret',
                                'contrats.duree_pret','contrats.differe','contrats.etat',
                                'clients.nom','clients.prenom','clients.numcompte','clients.codeagence','clients.clerib')
                        ->join('clients', 'clients.id', '=', 'contrats.client_id')
                        ->where('contrats.rapprochement_id',$id)
                        ->orderBy('id','desc')
                        ->get();
        $contrat_non_rapproches = DB::table('contrats')
                        ->select('contrats.id','contrats.numprojet','contrats.dateeffet','contrats.dateeche','contrats.montantpret','contrats.primetotale','contrats.montantpret',
                                'contrats.duree_pret','contrats.differe','contrats.etat',
                                'clients.nom','clients.prenom','clients.numcompte','clients.codeagence','clients.clerib')
                        ->join('clients', 'clients.id', '=', 'contrats.client_id')
                        ->whereBetween(
                            DB::raw("STR_TO_DATE(contrats.datesaisie, '%d/%m/%Y')"), 
                            [
                                DB::raw("STR_TO_DATE('$rapprochement->datedebut', '%d/%m/%Y')"), // Conversion de la première date
                                DB::raw("STR_TO_DATE('$rapprochement->datefin', '%d/%m/%Y')")
                            ]
                        )
                        ->where('contrats.rapprochement_id',NULL)
                        ->orderBy('id','desc')
                        ->get();
        return response()->json([
            "success" => true,
            "data" =>[
                        "rapprochement" =>$rapprochement,
                        "contrat_rapproches" =>$contrat_rapproches,
                        "contrat_non_rapproches" =>$contrat_non_rapproches,
            ]
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
