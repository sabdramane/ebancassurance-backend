<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garantie;
use App\Http\Requests\Garantie\GarantiePostRequest;
use App\Http\Requests\Garantie\GarantieUpdateRequest;


class GarantieController extends Controller
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
        return Garantie::orderBy('id', 'desc')->get();
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
    public function store(GarantiePostRequest $request)
    {
        Garantie::create($request->all());
        return response()->json([
            'message' => 'Garantie ajoutée avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Garantie::where('id', $id)->first();
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
    public function update(GarantieUpdateRequest $request, $id)
    {
        $garantie = Garantie::find($id);
        $garantie->codegara = $request->codegara;
        $garantie->libegara = $request->libegara;
        $garantie->descgara = $request->descgara;
        $garantie->save();
        return response()->json([
            'messge' => 'Mise à jour éffectuée'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $garantie = Garantie::find($id);
        $garantie->delete();
        return response()->json([
            'message' => 'Garantie supprimée'
        ]);
    }
}
