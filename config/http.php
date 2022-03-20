<?php
declare(strict_types=1);

return [
    'cookie'      => [
        'expires'  => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
        'httponly' => false,
        'sameSite' => '',
    ],
    'middlewares' => [
        'App\Exceptions\Handler',
        'Max\Foundation\Http\Middlewares\RoutingMiddleware',
        'App\Http\Middlewares\Statistic'
    ],
    'route'       => [
        'scanDir' => [
            __DIR__ . '/../app/Http/Controllers'
        ]
    ]
];
