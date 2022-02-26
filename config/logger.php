<?php

return [
    'default' => 'app',
    'logger'  => [
        'app' => [
            'handler' => 'Monolog\Handler\RotatingFileHandler',
            'options' => [
                'filename' => base_path('storage/logs.app.log'),
                'maxFiles' => 180,
                'level'    => \Monolog\Logger::WARNING,
            ],
        ],
    ],
];
