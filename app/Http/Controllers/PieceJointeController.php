<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\piecejointe\PieceJointeRequest;
use App\Models\PieceJointe;
use App\Models\Prestation;

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
            $fichier = $request->fichier_joint->move("storage/imports/prestations/documents/", $nom_fichier);
            
            $piecejointe->nom_document = $request->nom_document;
            $piecejointe->prestation_id = $request->prestation_id;
            $piecejointe->fichier_joint = $nom_fichier;
            $piecejointe->fichier_joint_ext = $extension_fichier;
            $piecejointe->save();

            $prestation = Prestation::find($request->prestation_id);
            $prestation->etat = "en cours de traitement";
            $prestation->save();
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


    public function downloadFile($filename)
    {

        $filepath = public_path('storage/imports/prestations/documents/' . $filename);

        if (file_exists($filepath)) {
            $mimeType = mime_content_type($filepath); 

            // Liste des types MIME pris en charge
            $allowedMimeTypes = [
                'application/pdf',          // PDF
                'image/jpeg',               // Images JPEG
                'image/png',                // Images PNG
                'application/msword',       // Fichiers Word (.doc)
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Fichiers Word (.docx)
                'application/vnd.ms-excel', // Fichiers Excel (.xls)
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Fichiers Excel (.xlsx)
            ];

            if (in_array($mimeType, $allowedMimeTypes)) {
                return response()->file($filepath, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline', // Ouvrir dans le navigateur si possible
                ]);
            } else {
                return response()->json(['message' => 'File type not supported for inline viewing.'], 400);
            }
        } else {
            return response()->json(['message' => 'File not found.'], 404);
        }
    }

}
