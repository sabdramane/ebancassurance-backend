<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratQuestionnaireResource extends JsonResource
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
            'valeur'=>$this->valeur,
            'description'=>$this->description,
            'datesurvenance'=>$this->datesurvenance,
            'contrat_id'=>$this->contrat_id,
            'questionnaire_medical_id'=>$this->questionnaire_medical_id,
            ];
    }
}
