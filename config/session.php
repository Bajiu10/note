<?php

return [
    'name'          => 'MAXPHP_SESSION_ID',
    'handler'       => [
        'class'   => '\Max\Session\Handlers\Redis',
        'options' => [
            'path' => env('storage_path') . 'session',
            'ttl'  => 3600,
        ]
    ],
    'cookie_expire' => time() + 3600,
];
