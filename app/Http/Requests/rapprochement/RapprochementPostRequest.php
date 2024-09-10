<?php

namespace App\Http\Requests\rapprochement;

use Illuminate\Foundation\Http\FormRequest;

class RapprochementPostRequest extends FormRequest
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
            'daterapproch'=>'required',
            'datecompt'=>'required',
            'montant'=>'required',
            'datedebut'=>'required',
            'datefin'=>'required'
        ];
    }
}
