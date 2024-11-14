<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return response()->json([
            "success" => true,
            "roles" => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            "success" => true,
            "message" => "Form to create a new role can be displayed here.",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $role = new Role();
        $role->libelle = $request->input('libelle');
        $role->description = $request->input('description');
        $role->save();

        return response()->json([
            "success" => true,
            "role" => $role,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }

        return response()->json([
            "success" => true,
            "role" => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }

        return response()->json([
            "success" => true,
            "role" => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $role->update($request->only(['libelle', 'description']));

        return response()->json([
            "success" => true,
            "role" => $role,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }

        $role->delete();

        return response()->json([
            "success" => true,
            "message" => "Role deleted successfully",
        ]);
    }
}
