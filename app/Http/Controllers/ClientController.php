<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\client\ClientPostRequest;
use App\Models\BdbanqueClient;
use App\Models\Client;
use App\Models\PreContrat;
use DateTime;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getInfosClient(Request $request)
    {
        $client = Client::where('codeagence',$request->codeagence)
                                    ->where('numcompte',$request->numcompte)
                                    ->where('clerib',$request->clerib)
                                    ->first();
        
        
        $precontrat = new PreContrat();
        $precontrat->save();

        if($client != null){
            $client->precontrat_id = $precontrat->id;
            return $client;
        }else{
            $bdbanque_clients = BdbanqueClient::where('codeagence',$request->codeagence)
                                            ->where('numcompte',$request->numcompte)
                                            ->where('clerib',$request->clerib)
                                            ->first();
            $bdbanque_clients->precontrat_id = $precontrat->id;
            return $bdbanque_clients;
        }
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientPostRequest $request)
    {
        $client = Client::where("codeagence",$request->codeagence)
                            ->where("numcompte",$request->numcompte)
                            ->where("clerib",$request->clerib)
                            ->first();
        if($client == null){
            $client = Client::create($request->all());    
        }else{
             $client->update($request->all());    
        }

        if ($files = $request->file('fichier_cnib')) {
            $nom_fichier = $request->fichier_cnib->hashName();
            $fichier = $request->fichier_cnib->move("storage/imports/fichier_cnib/", $nom_fichier);
            $client->fichier_cnib = $nom_fichier;
            $client->save();
        }
        $client->precontrat_id = $request->precontrat_id;

        return $client;
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
