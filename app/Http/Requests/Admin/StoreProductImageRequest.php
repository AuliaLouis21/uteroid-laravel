<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'filename' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_thumbnail' => ['nullable', 'boolean'],
        ];
    }
}
