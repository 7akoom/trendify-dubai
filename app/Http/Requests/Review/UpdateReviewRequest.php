<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rate' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ];
    }
}
