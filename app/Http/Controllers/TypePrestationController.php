<?php

namespace App\Http\Controllers;

use App\Http\Requests\typeprestation\TypeprestationrUpdateRequest;
use App\Http\Requests\typeprestation\TypeprestationPostRequest;
use App\Http\Resources\TypePrestationCollection;
use App\Http\Resources\TypePrestationResource;
use App\Models\TypePrestation;
use Illuminate\Http\Request;

class TypePrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typePrestations = TypePrestation::select('id', 'libelle')
            ->get();
        return response()->json([
            "success" => true,
            "data" => $typePrestations,
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
    public function store(TypeprestationPostRequest $request)
    {
        /* $typeprestation = $request->validated();
        $typeprestation['created_at'] = now();
        $typeprestation['updated_at'] = now();
        $typeprestation['libelle'] = $request->libelle;
        $tpcreate = TypePrestation::forceCreate($typeprestation);
        return new TypePrestationResource($tpcreate); */

        TypePrestation::create($request->post());
        return response()->json([
            'message' => 'Type de prestation ajouté avec succès'
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(TypePrestation $typeprestation)
    {
        return new TypePrestationResource($typeprestation);
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
    public function update(TypeprestationrUpdateRequest $request, TypePrestation $typeprestation)
    {
        $typeprestation->update($request->validated());
        return response()->json([
            'messge' => 'Mise à jour éffectuée'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypePrestation $typeprestation)
    {
        $typeprestation->delete();
        return response()->json([
            'message' => 'Type de prestation supprimé'
        ]);
    }
}
