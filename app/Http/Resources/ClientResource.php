<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'dateNaissance'=>$this->dateNaissance,
            'genre'=>$this->genre,
            'profession'=>$this->profession,
            'lieuNaissance'=>$this->lieuNaissance,
            'email'=>$this->email,
            'boitepostale'=>$this->boitepostale,
            'numcompte'=>$this->numcompte,
            'clerib'=>$this->clerib,
            'codeagence'=>$this->codeagence,
            'agence_id'=>$this->agence_id,
            ];
    }
}
