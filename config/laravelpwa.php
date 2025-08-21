<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'InYice-Lite'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72-white.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96-white.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128-white.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144-white.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152-white.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192-white.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384-white.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512-white.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136-white.png',
            '750x1334' => '/images/icons/splash-750x1334-white.png',
            '828x1792' => '/images/icons/splash-828x1792-white.png',
            '1125x2436' => '/images/icons/splash-1125x2436-white.png',
            '1242x2208' => '/images/icons/splash-1242x2208-white.png',
            '1242x2688' => '/images/icons/splash-1242x2688-white.png',
            '1536x2048' => '/images/icons/splash-1536x2048-white.png',
            '1668x2224' => '/images/icons/splash-1668x2224-white.png',
            '1668x2388' => '/images/icons/splash-1668x2388-white.png',
            '2048x2732' => '/images/icons/splash-2048x2732-white.png',
        ],
        'shortcuts' => [
            [
                'name' => 'InYice-Lite',
                'description' => 'InYice-Lite is a lightweight, self-hosted accounts management system.',
                'url' => '/inYiceLite',
                'icons' => [
                    "src" => "/images/icons/icon-72x72-white.png",
                    "purpose" => "any"
                ]
            ],
        ],
        'custom' => []
    ]
];
