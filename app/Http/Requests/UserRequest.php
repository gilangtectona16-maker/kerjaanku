<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah dijaga middleware role:admin
    }

    public function rules(): array
    {
        $user = $this->route('user'); // null saat create

        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'role'      => ['required', Rule::in(['admin', 'petugas'])],
            'is_active' => ['nullable', 'boolean'],
            'password'  => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }
}