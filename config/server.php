<?php

use Swoole\Constant;
use Max\Server\Http\Server;

return [
    'servers'  => [
        [
            'name'      => 'websocket',
            'server'    => \Max\Server\Server::SERVER_WEBSOCKET,
            'host'      => '0.0.0.0',
            'port'      => 9501,
            'sockType'  => SWOOLE_SOCK_TCP,
            'settings'  => [
                Constant::OPTION_OPEN_WEBSOCKET_PROTOCOL => true,
            ],
            'callbacks' => [
                'open'    => [\Max\Server\WebSocket\Server::class, 'open'],
                'message' => [\Max\Server\WebSocket\Server::class, 'message'],
                'close'   => [\Max\Server\WebSocket\Server::class, 'close'],
                'receive' => [\Max\Server\WebSocket\Server::class, 'receive']
            ],
        ],
        [
            'name'      => 'http',
            'server'    => \Max\Server\Server::SERVER_HTTP,
            'host'      => '0.0.0.0',
            'port'      => 8080,
            'sockType'  => SWOOLE_SOCK_TCP,
            'settings'  => [
                Constant::OPTION_MAX_REQUEST           => 10000,
                Constant::OPTION_ENABLE_STATIC_HANDLER => true,
                Constant::OPTION_OPEN_HTTP_PROTOCOL    => true,
            ],
            'callbacks' => [
                'request' => [Server::class, 'request'],
            ],
        ],
    ],
    'settings' => [
        Constant::OPTION_ENABLE_COROUTINE => true,
        Constant::OPTION_WORKER_NUM       => 4,
        //        Constant::OPTION_DAEMONIZE        => true,
    ],
];
