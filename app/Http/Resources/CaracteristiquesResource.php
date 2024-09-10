<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaracteristiquesResource extends JsonResource
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
            'capital'=>$this->capital,
            'duree'=>$this->duree,
            'traite'=>$this->traite,
            'garantie_id'=>$this->garantie_id,
            ];
    }
}
