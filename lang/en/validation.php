<?php

return [

    // ... other default messages

    'custom' => [
        'phone' => [
            'required' => 'Phone number is required.',
            'unique' => 'Phone number is already taken.',
            'regex' => 'The phone number must be a valid UAE number in the format 05XXXXXXXX or 9715XXXXXXXX.',
        ],
        'name' => [
            'required' => 'Name is required.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'email' => 'Email must be a valid email address.',
            'unique' => 'Email is already taken.',
        ],
        'password' => [
            'required' => 'Password is required.',
            'min' => 'Password must be at least 6 characters.',
            'confirmed' => 'Password confirmation does not match.',
        ],
    ],

];
