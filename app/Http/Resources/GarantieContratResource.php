<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GarantieContratResource extends JsonResource
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
        'prime'=>$this->prime,
        'capital'=>$this->capital,
        'garantie_id'=>$this->garantie_id,
        'contrat_id'=>$this->contrat_id,
        'produit_id'=>$this->produit_id,
        ];
    }
}
