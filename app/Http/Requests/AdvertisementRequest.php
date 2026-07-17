<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adsId = $this->route('advertisement')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:advertisements,slug,' . $adsId],
            'image' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'is_active' => ['boolean'],
        ];
    }
}
