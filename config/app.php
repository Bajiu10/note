<?php

return [
    'di'    => [
        // 依赖绑定
        'bindings' => [
            'Psr\Http\Server\RequestHandlerInterface' => 'App\Http\Kernel',
            'Psr\Http\Message\ServerRequestInterface' => 'App\Lib\ServerRequest',
        ],
    ],
    'theme' => 'mt'
];
