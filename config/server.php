<?php

use Max\Http\Server as HttpServer;
use Max\Server\Callbacks;
use Max\Server\Listeners\ServerListener;
use Max\Server\Server;
use Max\WebSocket\Server as WebSocketServer;
use Swoole\Constant;

return [
    'mode'      => SWOOLE_PROCESS,
    'servers'   => [
        [
            'name'      => 'websocket',
            'type'      => Server::SERVER_WEBSOCKET,
            'host'      => '0.0.0.0',
            'port'      => 9999,
            'sockType'  => SWOOLE_SOCK_TCP,
            'settings'  => [
                Constant::OPTION_OPEN_WEBSOCKET_PROTOCOL => true,
                Constant::OPTION_MAX_REQUEST             => 10000,
                Constant::OPTION_OPEN_HTTP_PROTOCOL      => true,
            ],
            'callbacks' => [
                ServerListener::EVENT_OPEN    => [WebSocketServer::class, 'OnOpen'],
                ServerListener::EVENT_MESSAGE => [WebSocketServer::class, 'OnMessage'],
                ServerListener::EVENT_CLOSE   => [WebSocketServer::class, 'OnClose'],
                ServerListener::EVENT_REQUEST => [HttpServer::class, 'onRequest'],
            ],
        ]
    ],
    'settings'  => [
        Constant::OPTION_ENABLE_COROUTINE => true,
        Constant::OPTION_WORKER_NUM       => 4,
        //        Constant::OPTION_DAEMONIZE        => true,
        Constant::OPTION_LOG_FILE         => __DIR__ . '/../runtime/logs/std.log',
    ],
    'callbacks' => [
        ServerListener::EVENT_TASK   => [Callbacks::class, 'onTask'],
        ServerListener::EVENT_FINISH => [Callbacks::class, 'onFinish'],
    ],
];
