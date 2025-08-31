<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiljkaUpdateRequest extends FormRequest
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
            'opisBiljke' => ['nullable', 'max:255', 'string'],
            'nazivBiljke' => ['required', 'max:30', 'string'],
            'sezona' => ['required', 'max:25', 'string'],
        ];
    }
}
