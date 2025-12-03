<?php

return [
    'api_key' => env('BUNNY_API_KEY', ''),
    'access_key' => env('BUNNY_ACCESS_KEY', ''),
    'storage_zone' => env('BUNNY_STORAGE_ZONE', 'capstone'),
    'cdn_url' => env('BUNNY_CDN_URL', 'https://capstone.b-cdn.net'),
    
    'upload' => [
        'max_size' => 10240, // 10MB en KB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'directory' => 'ordenes-servicio',
    ],
];
