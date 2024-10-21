<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\client\ClientPostRequest;
use App\Models\BdbanqueClient;
use App\Models\Client;
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
        $bdbanque_clients = BdbanqueClient::where('codeagence',$request->codeagence)
                                            ->where('numcompte',$request->numcompte)
                                            ->where('clerib',$request->clerib)
                                            ->first();
        return $bdbanque_clients;
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
