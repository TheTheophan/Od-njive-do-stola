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
            'cena_godisnje_pretplate' => ['nullable', 'numeric'],
            'cena_mesecne_pretplate' => ['nullable', 'numeric'],
            'opis' => ['nullable', 'max:9999', 'string'],
            'naziv' => ['required', 'max:64', 'string'],
        ];
    }
}
