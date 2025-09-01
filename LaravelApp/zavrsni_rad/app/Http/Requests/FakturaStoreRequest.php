<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FakturaStoreRequest extends FormRequest
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
            'paket_korisnika_id' => ['required', 'exists:paket_korisnikas,id'],
            'cena' => ['nullable', 'numeric'],
            'tekst' => ['nullable', 'max:254', 'string'],
            'placeno' => ['nullable', 'boolean'],
        ];
    }
}
