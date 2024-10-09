<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GarantieResource extends JsonResource
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
        'codegara'=>$this->codegara,
        'libegara'=>$this->libegara,
        'descgara'=>$this->descgara,
        'tarif_id'=>$this->tarif_id,
        ];
    }
}
