<?php

namespace App\Http\Requests\ShippingAddress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'country' => 'required|string',
            'post_code' => 'nullable|string',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
        ];
    }
}
