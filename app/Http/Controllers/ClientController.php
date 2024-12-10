<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\client\ClientPostRequest;
use App\Http\Requests\client\ClientUpdateRequest;
use App\Models\BdbanqueClient;
use App\Models\Client;
use App\Models\PreContrat;
use App\Models\Contrat;
use DateTime;

class ClientController extends Controller
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
            if ($bdbanque_clients != null) {
                $bdbanque_clients->precontrat_id = $precontrat->id;
                return $bdbanque_clients;
            }
        }

        $client = new Client();
        $client->precontrat_id = $precontrat->id;
        return $client;
        
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

        if ($files = $request->file('document_piece_identite')) {
            $nom_fichier = $request->document_piece_identite->hashName();
            $fichier = $request->document_piece_identite->move("storage/imports/document_piece_identite/", $nom_fichier);
            $client->document_piece_identite = $nom_fichier;
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
        
    }
    public function getClientStepEditContrat(string $id)
    {
        $contrat = Contrat::find($id);
        $client = $contrat->client;
        $client->contrat_id = $contrat->id;

        return response()->json([
            "success" => true,
            'client'=>$client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::find($id);
        
        $client->update($request->all());

        if ($files = $request->file('document_piece_identite')) {
            $nom_fichier = $request->document_piece_identite->hashName();
            $fichier = $request->document_piece_identite->move("storage/imports/document_piece_identite/", $nom_fichier);
            $client->document_piece_identite = $nom_fichier;
            $client->save();
        }
        //$client->contrat_id = $request->contrat_id;
        $contrat = Contrat::find($request->contrat_id);

        return response()->json([
            "success" => true,
            'contrat'=>$request
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateClient(Request $request) {
        $client = Client::find($request->id);
        
        $client->update($request->all());

        if ($files = $request->file('document_piece_identite')) {
            $nom_fichier = $request->document_piece_identite->hashName();
            $fichier = $request->document_piece_identite->move("storage/imports/document_piece_identite/", $nom_fichier);
            $client->document_piece_identite = $nom_fichier;
            $client->save();
        }
        //$client->contrat_id = $request->contrat_id;
        $contrat = Contrat::find($request->contrat_id);

        return response()->json([
            "success" => true,
            'contrat'=>$contrat
        ]);
    }
}
