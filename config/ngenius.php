<?php

return [
    'environment' => env('NGENIUS_ENVIRONMENT'),

    'production' => [
        'api_url' => 'https://api-gateway.ngenius-payments.com',
        'identity_url' => 'https://api-gateway.ngenius-payments.com/identity',
        'api_key' => env('NGENIUS_API_KEY'),
        'outlet_reference' => env('NGENIUS_OUTLET_REFERENCE'),
    ],

    'currency' => env('NGENIUS_CURRENCY', 'AED'),
    'return_url' => env('NGENIUS_RETURN_URL', '/payment/callback'),
    'webhook_url' => env('NGENIUS_WEBHOOK_URL', '/payment/webhook'),
];
