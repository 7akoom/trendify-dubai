<?php

namespace App\Http\Requests\Mail;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'phone'   => ['required', 'string', 'regex:/^\+971(50|51|52|54|55|56|58)\d{7}$/'],
            'email'   => 'required|email',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => __('contact.validation.name_required'),
            'name.string'      => __('contact.validation.name_string'),
            'name.max'         => __('contact.validation.name_max'),

            'phone.required'   => __('contact.validation.phone_required'),
            'phone.string'     => __('contact.validation.phone_string'),
            'phone.max'        => __('contact.validation.phone_max'),
            'phone.regex'      => __('contact.validation.phone_regex'),

            'email.required'   => __('contact.validation.email_required'),
            'email.email'      => __('contact.validation.email_email'),

            'message.required' => __('contact.validation.message_required'),
            'message.string'   => __('contact.validation.message_string'),
        ];
    }
}
