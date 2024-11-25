<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\prestation\PrestationPostRequest;
use App\Models\Client;
use App\Models\TypePrestation;
use App\Models\BdbanqueClient;
use App\Models\Prestation;


class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestations = Prestation::orderBy('id','desc')->get();
        return response()->json([
            "success" => true,
            "prestations" =>$prestations->load(['client', 'typePrestation']),
        ]);
        return $prestations;
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
    public function store(PrestationPostRequest $request)
    {
        $client = Client::where('codeagence',$request->codeagence)
                                    ->where('numcompte',$request->numcompte)
                                    ->where('clerib',$request->clerib)
                                    ->first();

        if($client == null){
           $bdbanque_clients = BdbanqueClient::where('codeagence',$request->codeagence)
                                            ->where('numcompte',$request->numcompte)
                                            ->where('clerib',$request->clerib)
                                            ->first();
            if ($bdbanque_clients == null) {
                $client = new Client();
                $client->codeagence =$request->codeagence; 
                $client->numcompte =$request->numcompte; 
                $client->clerib =$request->clerib; 
                $client->nom =$request->nom; 
                $client->prenom =$request->prenom; 
                $client->save(); 
            }else{
                $client = new Client();
                $client->codeagence =$request->codeagence; 
                $client->numcompte =$request->numcompte; 
                $client->clerib =$request->clerib; 
                $client->nom =$bdbanque_clients->nom; 
                $client->prenom =$bdbanque_clients->prenom; 
                $client->dateNaissance =$bdbanque_clients->dateNaissance; 
                $client->civilite =$bdbanque_clients->civilite; 
                $client->profession =$bdbanque_clients->profession; 
                $client->telephone =$bdbanque_clients->telephone; 
                $client->email =$bdbanque_clients->email; 
                $client->save(); 
            }
        }

        $prestation = new Prestation();
        $prestation->type_prestation_id = $request->type_prestation_id;
        $prestation->client_id = $client->id;
        $prestation->numerocontrat = $request->numerocontrat;
        $prestation->date_declaration = $request->date_declaration;
        $prestation->date_survenance = $request->date_survenance;
        $prestation->date_survenance = $request->date_survenance;
        
        if($files = $request->file('declaration')) {
            $nom_fichier = $request->declaration->hashName();
            $fichier = $request->declaration->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->declaration = $nom_fichier;
        }
        if ($files = $request->file('contrat_assurance')) {
            $nom_fichier = $request->contrat_assurance->hashName();
            $fichier = $request->contrat_assurance->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->contrat_assurance = $nom_fichier;
        }
        if ($files = $request->file('piece_identite')) {
            $nom_fichier = $request->piece_identite->hashName();
            $fichier = $request->piece_identite->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->piece_identite = $nom_fichier;
        }
        if ($files = $request->file('tableau_amortissement')) {
            $nom_fichier = $request->tableau_amortissement->hashName();
            $fichier = $request->tableau_amortissement->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->tableau_amortissement = $nom_fichier;
        }
        if ($files = $request->file('acte_deces')) {
            $nom_fichier = $request->acte_deces->hashName();
            $fichier = $request->acte_deces->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->acte_deces = $nom_fichier;
        }
        if ($files = $request->file('certificat_deces')) {
            $nom_fichier = $request->certificat_deces->hashName();
            $fichier = $request->certificat_deces->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->certificat_deces = $nom_fichier;
        }
        if ($files = $request->file('invalidite')) {
            $nom_fichier = $request->invalidite->hashName();
            $fichier = $request->invalidite->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->invalidite = $nom_fichier;
        }
        if ($files = $request->file('acte_licenciement')) {
            $nom_fichier = $request->acte_licenciement->hashName();
            $fichier = $request->acte_licenciement->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->acte_licenciement = $nom_fichier;
        }
        if ($files = $request->file('certificat_travail')) {
            $nom_fichier = $request->certificat_travail->hashName();
            $fichier = $request->certificat_travail->move("storage/imports/prestations/documents/", $nom_fichier);
            $prestation->certificat_travail = $nom_fichier;
        }
        $prestation->save();

        return response()->json([
            "success" => true,
            "prestation" =>$prestation,
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
