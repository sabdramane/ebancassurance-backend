<?php

namespace App\Http\Requests\tranche;

use Illuminate\Foundation\Http\FormRequest;

class TrancheAgePostRequest extends FormRequest
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
            'age_min'=>'required',
            'age_max'=>'required'
        ];
    }
}
