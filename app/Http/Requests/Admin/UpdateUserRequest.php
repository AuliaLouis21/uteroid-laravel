<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $allowedRoles = $this->user()->role === 'admin'
            ? ['admin', 'editor', 'viewer']
            : ['editor', 'viewer'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $this->route('user')->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role' => ['required', 'in:' . implode(',', $allowedRoles)],
        ];
    }
}
