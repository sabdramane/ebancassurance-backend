<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedecinResource extends JsonResource
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
            'statut'=>$this->statut,
            'datenomination'=>$this->datenomination,
            'datefin'=>$this->datefin,
            ];
    }
}
