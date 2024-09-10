<?php

namespace App\Http\Controllers;

use App\Http\Requests\agence\AgencePostRequest;
use App\Http\Requests\agence\AgenceUpdateRequest;
use App\Http\Resources\AgenceResource;
use App\Models\Agence;
use App\Models\Ville;
use Illuminate\Http\Request;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Agence::with('ville','banque')->get();
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
    public function store(AgencePostRequest $request)
    {
        Agence::create($request->post());
        return response()->json([
            'message' => 'Agence ajoutée avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agence $agence)
    {
        return new AgenceResource($agence);
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
    public function update(AgenceUpdateRequest $request, $id)
    {
        $agence = Agence::find($id);
        $agence->banque_id = $request->banque_id;
        $agence->ville_id = $request->ville_id;
        $agence->codeagence = $request->codeagence;
        $agence->libeagence = $request->libeagence;
        $agence->abrevagence = $request->abrevagence;
        $agence->adresse = $request->adresse;
        $agence->contact = $request->contact;
        $agence->save();

        //$agence->update($request->validated());
        return response()->json([
            'messge' => 'Mise à jour éffectuée'.$agence->abrevagence
        ]);
    }
    public function findAllByParams($libelleparams,$params_id)
    {
        return Agence::where($libelleparams,'=',$params_id)->with('ville')->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agence $agence)
    {
        $agence->delete();
        return response()->json([
            'message' => 'Agence supprimée'
        ]);
    }
}
