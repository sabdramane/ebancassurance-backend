<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Garantie;
use App\Models\ProduitGarantie;
use App\Models\BanqueProduit;
use App\Models\BanqueGarantieTarif;
use App\Http\Requests\produit\ProduitPostRequest;
use App\Http\Requests\produit\ProduitUpdateRequest;
class ProduitController extends Controller
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
        return Produit::where('id', $id)->with('produitgaranties')->first();
    }

    public function findAllByParams($libelleparams, $params_id)
    {
        return BanqueProduit::where($libelleparams, '=', $params_id)->with('produit')->get();
    }

    public function insertProduitToBanque(Request $request)
    {
        $produits = $request->produit_id;

        foreach ($produits as $produit) {
            $produit = Produit::find($produit);

            $produit_banque = BanqueProduit::where('produit_id', $produit->id)
                ->where('banque_id', $request->banque_id)
                ->first();
            $produit_garanties = ProduitGarantie::where('produit_id', $produit->id)
                ->get();
            if ($produit_banque == null) {
                $produit_banque = new BanqueProduit();
            }
            $produit_banque->produit_id = $produit->id;
            $produit_banque->banque_id = $request->banque_id;
            $produit_banque->save();

            foreach ($produit_garanties as $produit_garantie) {
                $banque_garantie_tarif = BanqueGarantieTarif::where('produit_id', $produit->id)
                    ->where('banque_id', $request->banque_id)
                    ->where('garantie_id', $produit_garantie->garantie_id)
                    ->first();
                if ($banque_garantie_tarif == null) {
                    $banque_garantie_tarif = new BanqueGarantieTarif();
                    $banque_garantie_tarif->produit_id = $produit->id;
                    $banque_garantie_tarif->banque_id = $request->banque_id;
                    $banque_garantie_tarif->garantie_id = $produit_garantie->garantie_id;
                    $banque_garantie_tarif->typegara = $produit_garantie->nature;
                    $banque_garantie_tarif->save();
                }
            }
        }
        return response()->json([
            'message' => 'Bien enregistré'
        ]);
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
    public function update(ProduitUpdateRequest $request, $id)
    {
        $produit = Produit::find($id);
        $produit->codeprod = $request->codeprod;
        $produit->libeprod = $request->libeprod;
        $produit->descprod = $request->descprod;
        $produit->save();

        $garanties_principales = $request->garantie_principal_id;
        $garanties_optionnelles = $request->garantie_optionnelle_id;

        foreach ($garanties_principales as $garanties_principale) {
            $garantie = Garantie::find($garanties_principale);

            $produit_garantie = ProduitGarantie::where('produit_id', $produit->id)
                ->where('garantie_id', $garantie->id)
                ->first();
            if ($produit_garantie == null) {
                $produit_garantie = new ProduitGarantie();
            }
            $produit_garantie->produit_id = $produit->id;
            $produit_garantie->garantie_id = $garantie->id;
            $produit_garantie->nature = "obligatoire";
            $produit_garantie->save();
        }
        if ($garanties_optionnelles != null) {
            foreach ($garanties_optionnelles as $garanties_optionnelle) {
                $garantie = Garantie::find($garanties_optionnelle);

                $produit_garantie_op = ProduitGarantie::where('produit_id', $produit->id)
                    ->where('garantie_id', $garantie->id)
                    ->first();
                if ($produit_garantie_op == null) {
                    $produit_garantie_op = new ProduitGarantie();
                }
                $produit_garantie_op->produit_id = $produit->id;
                $produit_garantie_op->garantie_id = $garantie->id;
                $produit_garantie_op->nature = "facultative";
                $produit_garantie_op->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
