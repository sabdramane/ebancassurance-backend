<?php

namespace App\Http\Requests\tarif;

use Illuminate\Foundation\Http\FormRequest;

class TarifUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codetarif'=>'required',
            'libetarif'=>'required',
            'typetarif'=>'required'
        ];
    }
}
