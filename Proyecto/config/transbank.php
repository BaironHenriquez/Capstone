<?php

return [
    // El SDK de Transbank espera 'TEST' para integración y 'LIVE' para producción
    'environment' => env('TRANSBANK_ENVIRONMENT', 'TEST'),
    
    'commerce_code' => env('TRANSBANK_COMMERCE_CODE', '597055555532'),
    
    'api_key' => env('TRANSBANK_API_KEY', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C'),
    
    'return_url' => env('APP_URL') . '/transbank/return',
    
    'environments' => [
        'integration' => 'https://webpay3gint.transbank.cl',
        'production' => 'https://webpay3g.transbank.cl',
    ],
];
