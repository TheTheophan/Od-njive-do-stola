<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlikaStoreRequest extends FormRequest
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
            'upotrebaSlike' => ['nullable', 'max:100', 'string'],
            'nazivDatoteke' => ['required', 'max:255', 'string'],
            'slika' => ['nullable', 'max:255'],
            'poljoprivrednikID' => [
                'required',
                'exists:poljoprivredniks,IDpoljoprivrednik',
            ],
        ];
    }
}
