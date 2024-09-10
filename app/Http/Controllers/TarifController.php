<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Tarif;
use App\Models\TableauTarif;
use App\Models\BanqueGarantieTarif;


class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tarif::orderBy('id','desc')->get();
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
        if ($files = $request->file('fichier_tarif')) {
            $extension_fichier = $request->fichier_tarif->getClientOriginalExtension();
            $fichier = $request->fichier_tarif->move("storage/imports/tarifs/", $request->fichier_tarif->hashName());
                $reader = SimpleExcelReader::create($fichier);
                $rows = $reader->getRows();
                
                //enregistrer du tarif
                $tarif = new Tarif();
                $tarif->codetarif = $request->codetarif;
                $tarif->libetarif = $request->libelle;
                $tarif->save();

                //enregistrement des données dans tableau_tarif
                foreach ($rows as $row) {
                    $tableau_tarif = new TableauTarif();
                    if($row['age'] !=''){
                        $tableau_tarif->age = $row['age'];
                    }
                    if($row['duree_min'] !=''){
                        $tableau_tarif->duree_min = $row['duree_min'];
                    }
                    if($row['duree_max'] !=''){
                        $tableau_tarif->duree_max = $row['duree_max'];
                    }
                    $tableau_tarif->taux = $row['taux'];
                    $tableau_tarif->tarif_id = $tarif->id;
                    $tableau_tarif->save();
                }
            return response()->json([
                'message' => 'Avec fichier joint'.$extension_fichier.' '.$request->codetarif
            ]);
        }else{
            $reeee = $request->fichier_tarif;
            return response()->json([
                'message' => 'Sans fichier joint   '.$reeee
            ]);
        }
    }

    public function insertTarifGarantieBanque(Request $request)
    {
        $banque_garantie_tarif = BanqueGarantieTarif::where('produit_id',$request->produit_id)
                                                ->where('banque_id',$request->banque_id)
                                                ->where('garantie_id',$request->garantie_id)
                                                ->first();
        $banque_garantie_tarif->tarif_id = $request->tarif_id;
        $banque_garantie_tarif->save();
        return response()->json([
            'message' => 'Bien enregistré!'
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
