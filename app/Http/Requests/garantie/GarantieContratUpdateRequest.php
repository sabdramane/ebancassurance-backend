<?php

namespace App\Http\Requests\garantie;

use Illuminate\Foundation\Http\FormRequest;

class GarantieContratUpdateRequest extends FormRequest
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
            'prime'=>'required',
            'capital'=>'required',
            'garantie_id'=>'required',
            'contrat_id'=>'required',
            'produit_id'=>'required'
        ];
    }
}
