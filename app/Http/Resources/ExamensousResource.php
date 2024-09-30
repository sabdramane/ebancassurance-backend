<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamensousResource extends JsonResource
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
        'categorie_produit_id'=>$this->categorie_produit_id,
        'examen_id'=>$this->examen_id,
        'tranche_age_id'=>$this->tranche_age_id,
        'tranche_capital_id'=>$this->tranche_capital_id,
        ];
    }
}
