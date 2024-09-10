<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BanqueResource extends JsonResource
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
            'codebanque'=>$this->codebanque,
            'libebanque'=>$this->libebanque,
            'siglebanque'=>$this->siglebanque,
            'adresse'=>$this->adresse,
            'contact'=>$this->contact,
            ];
    }
}
