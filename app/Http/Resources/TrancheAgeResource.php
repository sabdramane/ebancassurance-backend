<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrancheAgeResource extends JsonResource
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
            'libelle'=>$this->libelle,
            'age_min'=>$this->age_min,
            'age_max'=>$this->age_max
        ];
    }
}
