<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
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
        'codeprod'=>$this->codeprod,
        'libeprod'=>$this->libeprod,
        'descprod'=>$this->descprod,
        'categorie_produit_id'=>$this->categorie_produit_id,
        ];
    }
}
