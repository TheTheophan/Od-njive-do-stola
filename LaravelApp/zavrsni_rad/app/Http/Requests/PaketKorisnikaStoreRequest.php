<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaketKorisnikaStoreRequest extends FormRequest
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
            'godisnja_pretplata' => ['required', 'boolean'],
            'tip_paketa_id' => ['required', 'exists:tip_paketas,id'],
            'user_id' => ['required', 'exists:users,id'],
            'adresa' => ['required', 'max:254', 'string'],
            'uputstvo_za_dostavu' => ['nullable', 'max:254', 'string'],
            'broj_telefona' => ['nullable', 'max:18', 'string'],
            'postanski_broj' => ['nullable', 'max:20', 'string'],
        ];
    }
}
