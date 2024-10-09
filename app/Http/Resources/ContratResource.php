<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return [
            'id'=>$this->id,
            'numprojet'=>$this->numprojet,
            'dateeffet'=>$this->dateeffet,
            'dateeche'=>$this->dateeche,
            'datesaisie'=>$this->datesaisie,
            'duree'=>$this->duree,
            'periodicite'=>$this->periodicite,
            'differe'=>$this->differe,
            'traite'=>$this->traite,
            'etat'=>$this->etat,
            'fraisacces'=>$this->fraisacces,
            'primetotale'=>$this->primetotale,
            'produit_id'=>$this->produit_id,
            'agence_id'=>$this->agence_id,
            'client_id'=>$this->client_id,
            'rapprochement_id'=>$this->rapprochement_id,
            ];
    }
}
