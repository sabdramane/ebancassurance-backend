<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaireResource extends JsonResource
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
            'nom'=>$this->nom,
            'prenom'=>$this->prenom,
            'telephone'=>$this->telephone,
            'adresse'=>$this->adresse,
            'ville'=>$this->ville,
            'typebeneficiaire'=>$this->typebeneficiaire,
            'client_id'=>$this->client_id,
            'contrat_id'=>$this->contrat_id,
            ];
    }
}
