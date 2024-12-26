<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\piecejointe\PieceJointeRequest;
use App\Models\PieceJointe;

class PieceJointeController extends Controller
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
    public function store(PieceJointeRequest $request)
    {
    
        if ($files = $request->file('fichier_joint')) {
            $piecejointe = new PieceJointe();

            $extension_fichier = $request->fichier_joint->getClientOriginalExtension();
            $nom_fichier = $request->fichier_joint->hashName();
            $fichier = $request->fichier_joint->move("storage/imports/prestation/documents/", $nom_fichier);
            
            $piecejointe->nom_document = $request->nom_document;
            $piecejointe->prestation_id = $request->prestation_id;
            $piecejointe->fichier_joint = $nom_fichier;
            $piecejointe->fichier_joint_ext = $extension_fichier;
            $piecejointe->save();
        }
        return response()->json([
            'message' => 'Pièce jointe ajoutée avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function getPieceJointes($prestation_id)
    {
        $piecejointes = PieceJointe::where('prestation_id',$prestation_id)->get();
        return response()->json([
            "success" => true,
            "piecejointes" =>$piecejointes,
        ]);    
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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
