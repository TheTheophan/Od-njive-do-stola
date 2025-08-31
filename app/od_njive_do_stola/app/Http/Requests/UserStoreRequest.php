<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'adresaDostave' => ['nullable', 'max:100', 'string'],
            'uputstvoZaDostavu' => ['nullable', 'max:255', 'string'],
            'brojTelefona' => ['required', 'max:18', 'string'],
            'postanskiBroj' => ['required', 'max:20', 'string'],
            'gradID' => ['required', 'exists:grads,IDgrad'],
            'is_admin' => ['required', 'boolean'],
            'poljoprivrednikID' => [
                'required',
                'exists:poljoprivredniks,IDpoljoprivrednik',
            ],
        ];
    }
}
