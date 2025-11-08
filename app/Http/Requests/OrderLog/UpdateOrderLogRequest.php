<?php

namespace App\Http\Requests\OrderLog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'type' => 'required|string',
            'payment_status' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
}
