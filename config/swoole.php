<?php

return [
    'servers'  => [
        [
            'name'      => 'websocket',
            'server'    => \Max\Swoole\Server::SERVER_WEBSOCKET,
            'host'      => '0.0.0.0',
            'port'      => 9501,
            'sock_type' => SWOOLE_SOCK_TCP,
            'settings'  => [
                'open_websocket_protocol' => true,
                'enable_coroutine'        => true,
            ],
            'callbacks' => [
                'open'    => [\Max\Swoole\Server\WebSocket::class, 'open'],
                'message' => [\Max\Swoole\Server\WebSocket::class, 'message'],
                'close'   => [\Max\Swoole\Server\WebSocket::class, 'close'],
                'receive' => [\Max\Swoole\Server\WebSocket::class, 'receive'],
                'request' => [\Max\Swoole\Server\WebSocket::class, 'request'],
            ],
        ],
        [
            'name'      => 'http',
            'server'    => \Max\Swoole\Server::SERVER_HTTP,
            'host'      => '0.0.0.0',
            'port'      => 8080,
            'sock_type' => SWOOLE_SOCK_TCP,
            'settings'  => [
                'document_root'         => env('public_path'),
                'enable_static_handler' => true,
                'open_http_protocol'    => true,
                'enable_coroutine'      => true,
            ],
            'callbacks' => [
                'request' => [\Max\Swoole\Server\Http::class, 'request'],
            ],
        ],
    ],
    'settings' => [],
];