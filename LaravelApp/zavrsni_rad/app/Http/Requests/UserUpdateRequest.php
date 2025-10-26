<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->user),
                'email',
            ],
            'password' => ['nullable'],
        ];
    }
}
