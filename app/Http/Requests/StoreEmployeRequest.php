<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeRequest extends FormRequest
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
            'deps_id' => 'required|integer',
            'nom' => 'required|string',
            'prenom' =>'required|string',
            'email' =>'required|unique:employers,email',
            'contact' => 'required|unique:employers,contact',
            'montant_journalier'=>'required'
        ];
    }
    public function messages()
    {


        return [
            'email.required' => 'Le mail est requis',
            'email.unique' => 'Le mail est déjà pris',
            'contact.required' => 'Le numéro de telephone est requis',
            'contact.unique' => 'Le numéro de telephone est déjà pris'

        ];
    }
}
