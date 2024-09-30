<?php

namespace App\Http\Requests\simulation;

use Illuminate\Foundation\Http\FormRequest;

class SimulationPostRequest extends FormRequest
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
            'id'=>'required',
            'dateeche'=>'required',
            'datenaissance'=>'required',
            'duree'=>'required',
            'fraisacces'=>'required',
            'periodicite'=>'required',
            'differe'=>'required',
            'traite'=>'required',
            'primetotale'=>'required',
            'agence_id'=>'required',
            'produit_id'=>'required'
        ];
    }
}
