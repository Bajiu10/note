<?php

return [
    'session' => [
        'handler' => '\Max\Session\Store\Cache',
        'options' => [
            'name'          => 'MAXPHP_SESSION_ID',
            'path'          => env('storage_path') . 'session',
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
