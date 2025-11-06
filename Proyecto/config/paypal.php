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

    'subscription' => [
        'name' => 'Servicio Técnico - Sistema de Gestión',
        'description' => 'Acceso completo al sistema de gestión de órdenes de servicio técnico',
        'features' => [
            'Gestión completa de órdenes de servicio',
            'Control de inventario y equipos',
            'Gestión de clientes y técnicos',
            'Reportes y estadísticas',
            'Soporte técnico',
            'Actualizaciones gratuitas',
        ],
    ],

    'periods' => [
        'monthly' => [
            'name' => 'Mensual',
            'price' => 29990,
            'currency' => 'CLP',
            'interval' => 'month',
            'interval_count' => 1,
            'discount' => 0,
        ],
        'quarterly' => [
            'name' => 'Trimestral',
            'price' => 79990,
            'currency' => 'CLP',
            'interval' => 'month',
            'interval_count' => 3,
            'discount' => 10, // 10% descuento
            'original_price' => 89970,
        ],
        'yearly' => [
            'name' => 'Anual',
            'price' => 299990,
            'currency' => 'CLP',
            'interval' => 'year',
            'interval_count' => 1,
            'discount' => 16, // 16% descuento
            'original_price' => 359880,
        ],
    ],
];