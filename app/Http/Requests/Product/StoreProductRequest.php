<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id'    => ['required', 'exists:categories,id'],
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'is_featured'    => ['boolean'],
            'is_active'      => ['boolean'],
            'is_new'         => ['boolean'],
            'qty'            => ['required', 'numeric'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price'     => ['required', 'numeric'],
            'discount_price'     => ['nullable', 'numeric'],
            'images'         => ['nullable', 'array', 'max:4'],
            'images.*'       => ['image', 'max:2048'],
            'has_variants'   => ['boolean'],
        ];

        // في حال وجود متغيرات، نسمح بإرسال أي تركيبة من الألوان والمقاسات أو حتى تركهم فارغين
        if ($this->boolean('has_variants')) {
            $rules['colors'] = ['nullable', 'array'];
            $rules['colors.*.color_id'] = ['nullable', 'exists:colors,id'];

            $rules['sizes'] = ['nullable', 'array'];
            $rules['sizes.*.size_id'] = ['nullable', 'exists:sizes,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'يرجى اختيار الفئة.',
            'category_id.exists'   => 'الفئة المختارة غير صحيحة.',
            'name.required'        => 'يرجى إدخال اسم المنتج.',
            'qty.required'         => 'يرجى إدخال الكمية.',
            'purchase_price.required' => 'يرجى إدخال سعر الشراء.',
            'sale_price.required'     => 'يرجى إدخال سعر المبيع.',
            'images.array'         => 'يرجى رفع الصور بشكل صحيح.',
            'images.*.image'       => 'كل ملف يجب أن يكون صورة صحيحة.',
            'images.*.max'         => 'حجم كل صورة يجب ألا يتجاوز 2 ميجابايت.',
            'colors.*.color_id.exists' => 'لون غير موجود.',
            'sizes.*.size_id.exists'   => 'مقاس غير موجود.',
        ];
    }
}
