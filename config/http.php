<?php

return [
    'session' => [
        'handler' => \Max\Foundation\Http\Session\Store\Cache::class,
        'options' => [
            'name'          => 'PHP_SESSION_ID',
            'path'          => env('cache_path') . 'app',
            'cookie_expire' => time() + 3600,
        ],
    ],
    'cookie'  => [
        'expires'  => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
        'httponly' => false,
        'samesite' => '',
    ],
];
