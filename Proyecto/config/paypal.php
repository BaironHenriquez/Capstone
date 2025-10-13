<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayPal Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayPal REST API SDK
    |
    */

    'client_id' => env('PAYPAL_CLIENT_ID'),
    'client_secret' => env('PAYPAL_CLIENT_SECRET'),
    'mode' => env('PAYPAL_MODE', 'sandbox'), // 'sandbox' or 'live'
    'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
    
    'settings' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 30,
        'http.Retry' => 1,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path('logs/paypal.log'),
        'log.LogLevel' => 'ERROR',
    ],

    'plans' => [
        'basic' => [
            'name' => 'Servicio Técnico Básico',
            'description' => 'Acceso al sistema de gestión de servicio técnico',
            'price' => 29.99,
            'currency' => 'USD',
            'interval' => 'month',
        ],
        'premium' => [
            'name' => 'Servicio Técnico Premium',
            'description' => 'Acceso completo con funcionalidades avanzadas',
            'price' => 49.99,
            'currency' => 'USD',
            'interval' => 'month',
        ],
    ],
];