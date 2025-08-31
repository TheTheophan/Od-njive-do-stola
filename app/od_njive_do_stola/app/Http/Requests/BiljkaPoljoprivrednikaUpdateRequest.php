<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiljkaPoljoprivrednikaUpdateRequest extends FormRequest
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
            'biljkaID' => ['required', 'exists:biljkas,IDbiljka'],
            'poljoprivrednikID' => [
                'required',
                'exists:poljoprivredniks,IDpoljoprivrednik',
            ],
            'minNedeljniPrinos' => ['nullable', 'numeric'],
            'stanjeBiljke' => ['nullable', 'max:255', 'string'],
        ];
    }
}
