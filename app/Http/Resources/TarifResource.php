<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TarifResource extends JsonResource
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
            'codetarif'=>$this->codetarif,
            'libetarif'=>$this->libetarif,
            'typetarif'=>$this->typetarif
        ];
    }
}
