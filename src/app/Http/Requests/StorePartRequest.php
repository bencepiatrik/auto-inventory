<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $qty = $this->input('quantity');
        $this->merge([
            'quantity' => is_numeric($qty) ? (int)$qty : $qty,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'serialnumber' => ['required', 'string', 'max:255'],
            'quantity'     => ['required', 'integer', 'min:1'],
            'car_id'       => ['required', 'integer', 'exists:cars,id'],
        ];
    }
}
