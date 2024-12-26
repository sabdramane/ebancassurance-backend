<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\commentaire\CommentaireRequest;
use App\Models\Commentaire;


class CommentaireController extends Controller
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
    public function store(CommentaireRequest $request)
    {
        Commentaire::create($request->post());
        return response()->json([
            'message' => 'commentaire ajoutée avec succès'
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
        
    }

    public function getCommentaires($prestation_id)
    {
        $commentaires = Commentaire::where('prestation_id',$prestation_id)->get();
        return response()->json([
            "success" => true,
            "commentaires" =>$commentaires,
        ]);
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
