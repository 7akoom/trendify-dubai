<?php

namespace App\Http\Requests\Size;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',  Rule::unique('sizes', 'name')->ignore($this->size->id)],
        ];
    }
}
