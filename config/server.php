<?php

use Swoole\Constant;
use Max\Http\Server;

return [
    'mode'      => SWOOLE_PROCESS,
    'servers'   => [
        [
            'name'      => 'websocket',
            'type'      => \Max\Server\Server::SERVER_WEBSOCKET,
            'host'      => '0.0.0.0',
            'port'      => 8787,
            'sockType'  => SWOOLE_SOCK_TCP,
            'settings'  => [
                Constant::OPTION_OPEN_WEBSOCKET_PROTOCOL => true,
            ],
            'callbacks' => [
                'open'    => [\Max\WebSocket\Server::class, 'open'],
                'message' => [\Max\WebSocket\Server::class, 'message'],
                'close'   => [\Max\WebSocket\Server::class, 'close'],
                'receive' => [\Max\WebSocket\Server::class, 'receive']
            ],
        ],
        [
            'name'      => 'http',
            'type'      => \Max\Server\Server::SERVER_HTTP,
            'host'      => '0.0.0.0',
            'port'      => 9999,
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
    'settings'  => [
        Constant::OPTION_ENABLE_COROUTINE => true,
        Constant::OPTION_WORKER_NUM       => 4,
//        Constant::OPTION_DAEMONIZE        => true,
        Constant::OPTION_LOG_FILE         => __DIR__ . '/../runtime/logs/std.log',
    ],
    'callbacks' => [
        'start'        => [\Max\Server\Callbacks::class, 'start'],
        'workerStart'  => [\Max\Server\Callbacks::class, 'workerStart'],
        'task'         => [\Max\Server\Callbacks::class, 'task'],
        'finish'       => [\Max\Server\Callbacks::class, 'finish'],
        'managerStart' => [\Max\Server\Callbacks::class, 'managerStart'],
    ],
];
