<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoljoprivrednikStoreRequest extends FormRequest
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
            'adresa' => ['required', 'max:100', 'string'],
            'ime' => ['required', 'max:59', 'string'],
            'prezime' => ['required', 'max:60', 'string'],
            'gradID' => ['required', 'exists:grads,IDgrad'],
            'opisAdrese' => ['nullable', 'max:255', 'string'],
            'brojTelefona' => ['required', 'max:18', 'string'],
            'brojHektara' => ['required', 'numeric'],
            'brojGazdinstva' => ['required', 'max:12', 'string'],
            'plastenickaProizvodnja' => ['required', 'boolean'],
        ];
    }
}
