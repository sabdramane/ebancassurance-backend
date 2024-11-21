<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgenceUser;
use Illuminate\Support\Facades\Validator;

class AffectationController extends Controller
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            'agence_id' => 'required|integer|exists:agences,id',
            'user_id' => 'required|integer|exists:users,id',
            'date_affectation' => 'required|date',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affectations = AgenceUser::with(['agence', 'user'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "success" => true,
            "data" => $affectations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            "success" => true,
            "message" => "Form to create a new affectation can be displayed here.",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Création de l'affectation
        $affectation = AgenceUser::create($request->only(['agence_id', 'user_id', 'date_affectation']));

        return response()->json([
            "success" => true,
            "message" => "Affectation créée avec succès.",
            "data" => $affectation,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $affectation = AgenceUser::with(['agence', 'user'])->find($id);

        if (!$affectation) {
            return response()->json([
                "success" => false,
                "message" => "Affectation non trouvée.",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $affectation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $affectation = AgenceUser::find($id);

        if (!$affectation) {
            return response()->json(["error" => "Affectation not found"], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $affectation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $affectation = AgenceUser::find($id);

        if (!$affectation) {
            return response()->json([
                "success" => false,
                "message" => "Affectation non trouvée.",
            ], 404);
        }
       

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $affectation->date_desaffectation = $request->date_affectation;
        $affectation->save();
        //$affectation->update($request->only(['agence_id', 'user_id', 'date_affectation']));
        $affectation = AgenceUser::create($request->only(['agence_id', 'user_id', 'date_affectation']));

        return response()->json([
            "success" => true,
            "message" => "Affectation mise à jour avec succès.",
            "data" => $affectation,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $affectation = AgenceUser::find($id);

        if (!$affectation) {
            return response()->json([
                "success" => false,
                "message" => "Affectation non trouvée.",
            ], 404);
        }

        $affectation->delete();

        return response()->json([
            "success" => true,
            "message" => "Affectation supprimée avec succès.",
        ]);
    }
}
