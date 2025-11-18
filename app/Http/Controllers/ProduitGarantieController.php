<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Garantie;
use App\Models\ProduitGarantie;
use App\Http\Requests\produit\ProduitPostRequest;

class ProduitGarantieController extends Controller
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
        return Produit::all();
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
    public function store(ProduitPostRequest $request)
    {
        $produit = new Produit();
        $produit->codeprod = $request->codeprod;
        $produit->libeprod = $request->libeprod;
        $produit->descprod = $request->descprod;
        $produit->save();

        $garanties_principales = $request->garantie_principal_id;
        $garanties_optionnelles = $request->garantie_optionnelle_id;

        foreach ($garanties_principales as $garanties_principale) {
            $garantie = Garantie::find($garanties_principale);

            $produit_garantie = new ProduitGarantie();
            $produit_garantie->produit_id = $produit->id;
            $produit_garantie->garantie_id = $garantie->id;
            $produit_garantie->nature = "obligatoire";
            $produit_garantie->save();
        }
        if ($garanties_optionnelles != null) {
            foreach ($garanties_optionnelles as $garanties_optionnelle) {
                $garantie = Garantie::find($garanties_optionnelle);

                $produit_garantie = new ProduitGarantie();
                $produit_garantie->produit_id = $produit->id;
                $produit_garantie->garantie_id = $garantie->id;
                $produit_garantie->nature = "facultative";
                $produit_garantie->save();
            }
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ProduitGarantie::where('id', $id)->with('produit', 'garantie')->get();
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
