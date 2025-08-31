<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaketBiljakaStoreRequest extends FormRequest
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
            'biljkaPoljoprivrednikaID' => [
                'required',
                'exists:biljka_poljoprivrednikas,IDbiljkaPoljoprivrednika',
            ],
            'kilaza' => ['nullable', 'numeric'],
        ];
    }
}
