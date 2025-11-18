<?php

namespace App\Http\Controllers;

use App\Http\Requests\ville\VillePostRequest;
use App\Http\Requests\ville\VilleUpdateRequest;
use App\Http\Resources\VilleResource;
use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
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
        return Ville::select('id', 'libeville')
            ->orderBy('libeville')->get();
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
    public function store(VillePostRequest $request)
    {
        Ville::create($request->post());
        return response()->json([
            'message' => 'Ville ajouté avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ville $ville)
    {
        return new VilleResource($ville);
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
    public function update(VilleUpdateRequest $request, Ville $ville)
    {
        $ville->update($request->validated());
        return response()->json([
            'messge' => 'Mise à jour éffectuée'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ville $ville)
    {
        $ville->delete();
        return response()->json([
            'message' => 'Ville supprimée'
        ]);
    }
}
