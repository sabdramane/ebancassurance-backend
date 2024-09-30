<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenceResource extends JsonResource
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
            'codeagence'=>$this->codeagence,
            'libeagence'=>$this->libeagence,
            'abrevagence'=>$this->abrevagence,
            'adresse'=>$this->adresse,
            'contact'=>$this->contact,
            'banque_id'=>$this->banque_id,
            'ville_id'=>$this->ville_id,
            ];
    }
}
