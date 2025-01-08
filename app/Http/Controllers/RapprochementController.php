<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Contrat;
use App\Models\Rapprochement;

class RapprochementController extends Controller
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
                    "message" =>"Rapprochement effectué avec succès",
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
                    "montant total reçu" =>$montanttotal_fichier,
                    "montant rapproché" =>$montantrapproche,
                    "montant non rapproché" =>$montant_non_rapproche,
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
