<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RapprochementResource extends JsonResource
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
        'daterapproch'=>$this->daterapproch,
        'datecompt'=>$this->datecompt,
        'montant'=>$this->montant,
        'datedebut'=>$this->datedebut,
        'datefin'=>$this->datefin,
        ];
    }
}
