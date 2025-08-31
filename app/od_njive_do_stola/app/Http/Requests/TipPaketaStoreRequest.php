<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipPaketaStoreRequest extends FormRequest
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
            'cenaGodisnjePretplate' => ['required', 'numeric'],
            'cenaMesecnePretplate' => ['required', 'numeric'],
            'opisPaketa' => ['required', 'max:700', 'string'],
            'nazivPaketa' => ['required', 'max:40', 'string'],
            'cenaRezervacije' => ['required', 'numeric'],
        ];
    }
}
