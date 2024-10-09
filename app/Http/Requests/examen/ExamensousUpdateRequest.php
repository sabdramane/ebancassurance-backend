<?php

namespace App\Http\Requests\examen;

use Illuminate\Foundation\Http\FormRequest;

class ExamensousUpdateRequest extends FormRequest
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
            'categorie_produit_id'=>'required',
            'examen_id'=>'required',
            'tranche_age_id'=>'required',
            'tranche_capital_id'=>'required',
        ];
    }
}
