<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $productId],
            'image' => ['nullable', 'string', 'max:255'],
            'size' => ['nullable', 'string', 'max:100'],
            'thickness' => ['nullable', 'string', 'max:100'],
            'min_order' => ['nullable', 'integer', 'min:1'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'product_type_id' => ['nullable', 'exists:product_types,id'],
            'is_promo' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'published_time' => ['nullable', 'string', 'max:20'],
        ];
    }
}
