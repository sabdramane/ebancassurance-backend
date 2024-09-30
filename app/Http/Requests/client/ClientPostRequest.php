<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ClientPostRequest extends FormRequest
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
            'nom'=>'required',
            'prenom'=>'required',
            'telephone'=>'required',
            'dateNaissance'=>'required',
            'genre'=>'required',
            'profession'=>'required',
            'lieuNaissance'=>'required',
            'email'=>'required',
            'boitepostale'=>'required',
            'numcompte'=>'required',
            'clerib'=>'required',
            'codeagence'=>'required',
            'agence_id'=>'required',
        ];
    }
}
