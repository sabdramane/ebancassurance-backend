<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banque;
use App\Models\BanqueGarantieTarif;
use App\Http\Requests\banque\BanqueUpdateRequest;

class BanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Banque::orderBy('id','desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return "OK";
    }

    public function findAllByParams($libelleparams,$params_id)
    {
        return BanqueGarantieTarif::where($libelleparams,'=',$params_id)
                                    ->with('produit')
                                    ->with('banque')
                                    ->with('garantie')
                                    ->with('tarif')
                                    ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Banque::create($request->all());
        return response()->json([
            'message' => 'Banque ajouté avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Banque::where('id',$id)->first();
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
    public function update(BanqueUpdateRequest $request, Banque $banque)
    {
        
        $banque->update($request->validated());
        return response()->json([
            'messge' => 'Mise à jour éffectuée'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banque $banque)
    {
        $banque->delete();
        return response()->json([
            'message' => 'Banque supprimée'
        ]);
    }
}
