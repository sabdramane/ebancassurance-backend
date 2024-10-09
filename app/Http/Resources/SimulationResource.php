<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimulationResource extends JsonResource
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
        'dateeche'=>$this->dateeche,
        'datenaissance'=>$this->datenaissance,
        'duree'=>$this->duree,
        'fraisacces'=>$this->fraisacces,
        'periodicite'=>$this->periodicite,
        'differe'=>$this->differe,
        'traite'=>$this->traite,
        'primetotale'=>$this->primetotale,
        'agence_id'=>$this->agence_id,
        'produit_id'=>$this->produit_id,
    ];
    }
}
