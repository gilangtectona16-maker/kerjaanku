<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'plate_number' => strtoupper(preg_replace('/\s+/', ' ', trim($this->plate_number ?? ''))),
        ]);
    }

    public function rules(): array
    {
        return [
            'plate_number' => ['required', 'string', 'max:12'],
            'owner_name'   => ['nullable', 'string', 'max:100'],
            'slot_id'      => ['required', 'exists:slots,id'],
        ];
    }
}