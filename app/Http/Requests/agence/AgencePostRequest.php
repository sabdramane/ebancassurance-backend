<?php

namespace App\Http\Requests\agence;

use Illuminate\Foundation\Http\FormRequest;

class AgencePostRequest extends FormRequest
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
            'codeagence'=>'required',
            'libeagence'=>'required',
            'banque_id'=>'required',
            'ville_id'=>'required',
        ];
    }
}
