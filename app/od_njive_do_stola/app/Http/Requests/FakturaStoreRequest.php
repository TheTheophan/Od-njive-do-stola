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
            'paketKorisnikaID' => [
                'required',
                'exists:paket_korisnikas,IDpaketKorisnika',
            ],
            'cena' => ['required', 'numeric'],
            'tekstFakture' => ['nullable', 'max:255', 'string'],
            'placeno' => ['required', 'boolean'],
            'datumPlacanja' => ['nullable', 'date'],
        ];
    }
}
