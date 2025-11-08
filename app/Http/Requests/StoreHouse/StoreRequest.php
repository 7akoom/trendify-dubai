<?php

namespace App\Http\Requests\StoreHouse;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'use_variant_prices' => 'required|in:0,1',
        ];

        if ($this->use_variant_prices == 0) {
            $rules += [
                'qty' => 'required|numeric|min:0',
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
            ];
        } else {
            $rules += [
                'variants' => 'required|array|min:1',
                'variants.*.color_id' => 'sometimes|nullable|exists:colors,id',
                'variants.*.size_id' => 'sometimes|nullable|exists:sizes,id',
                'variants.*.purchase_price' => 'nullable|numeric|min:0',
                'variants.*.sale_price' => 'nullable|numeric|min:0',
                'variants.*.qty' => 'nullable|numeric|min:0',
            ];
        }

        return $rules;
    }
}
