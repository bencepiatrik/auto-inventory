<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // normalize boolean
        $isRegistered = filter_var($this->input('is_registered'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $this->merge([
            'is_registered' => $isRegistered ?? false,
            // ak nie je registrované, reg. číslo môže byť null
            'registration_number' => ($isRegistered ?? false) ? $this->input('registration_number') : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'is_registered' => ['required', 'boolean'],
            'registration_number' => [
                Rule::requiredIf((bool)$this->boolean('is_registered')),
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
