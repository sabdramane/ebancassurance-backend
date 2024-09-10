<?php

namespace App\Http\Requests\tranche;

use Illuminate\Foundation\Http\FormRequest;

class TrancheCapitalUpdateRequest extends FormRequest
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
            'libelle'=>'required',
            'capital_min'=>'required',
            'capital_max'=>'required',
                ];
    }
}
