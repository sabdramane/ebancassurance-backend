<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'civilite'=>'required',
            'profession'=>'required',
        ];
    }
}
