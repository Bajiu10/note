<?php

return [
    'scanner'  => [
        'cache'      => false,
        'paths'      => [
            BASE_PATH . 'app',
        ],
        'collectors' => [
            'Max\Event\ListenerCollector',
            'Max\Http\RouteCollector',
            'Max\Console\CommandCollector',
        ],
        'runtimeDir' => BASE_PATH . 'runtime',
    ],
    // 依赖绑定
    'bindings' => [
        'Psr\Http\Server\RequestHandlerInterface' => 'App\\Http\\Kernel',
        'Psr\Http\Message\ServerRequestInterface' => 'App\\Http\\Utils\\ServerRequest',
        'Psr\Http\Message\ResponseInterface'      => 'App\\Http\\Utils\\Response',
    ],
];
