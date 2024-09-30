<?php

namespace App\Http\Requests\contrat;

use Illuminate\Foundation\Http\FormRequest;

class ContratUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'numprojet'=>'required',
            'dateeffet'=>'required',
            'dateeche'=>'required',
            'datesaisie'=>'required',
            'duree'=>'required',
            'periodicite'=>'required',
            'differe'=>'required',
            'traite'=>'required',
            'etat'=>'required',
            'fraisacces'=>'required',
            'primetotale'=>'required',
            'produit_id'=>'required',
            'agence_id'=>'required',
            'client_id'=>'required',
            'rapprochement_id'=>'required',
        ];
    }
}
