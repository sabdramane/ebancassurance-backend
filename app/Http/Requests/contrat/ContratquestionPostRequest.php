<?php

namespace App\Http\Requests\contrat;

use Illuminate\Foundation\Http\FormRequest;

class ContratquestionPostRequest extends FormRequest
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
            'valeur'=>'required',
            'description'=>'required',
            'datesurvenance'=>'required',
            'contrat_id'=>'required',
            'questionnaire_medical_id'=>'required',
        ];
    }
}
