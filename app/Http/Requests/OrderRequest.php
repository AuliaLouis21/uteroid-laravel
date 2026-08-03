<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\ValidatesRecaptcha;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class OrderRequest extends FormRequest
{
    use ValidatesRecaptcha;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'message' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
            'items.*.product_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) {
                if (!preg_match('/items\.(\d+)\.quantity/', $attribute, $m)) {
                    return;
                }

                $productId = $this->input("items.{$m[1]}.product_id");
                if (! $productId) {
                    return;
                }

                $product = Product::find($productId);
                if ($product && $value < $product->min_order) {
                    $fail("Jumlah order minimal {$product->min_order} untuk {$product->name}.");
                }
            }],
            'items.*.length_cm' => ['nullable', 'numeric', 'min:0'],
            'items.*.width_cm' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
