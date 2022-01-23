<?php

return [
    'name'          => 'MAXPHP_SESSION_ID',
    'handler'       => [
        'class'   => '\Max\Session\Handlers\File',
        'options' => [
            'path' => env('storage_path') . 'session',
            'ttl'  => 3600,
        ]
    ],
    'cookie_expire' => time() + 3600,
];
