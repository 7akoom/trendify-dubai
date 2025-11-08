<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => ['image', 'max:2048'],
            'description' => 'nullable|string',
            'status' => ['boolean'],
        ];
    }
}
