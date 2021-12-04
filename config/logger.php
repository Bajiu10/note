<?php

return [
    'default' => 'app',
    'logger'  => [
        'app' => [
            'handler' => \Monolog\Handler\StreamHandler::class,
            'path'    => env('storage_path') . 'logs/' . date('Ym') . '/' . date('d') . '.log',
            'level'   => \Monolog\Logger::WARNING,
        ],
    ],
];
