<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FakturaUpdateRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
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
