<?php

return [
    'scanDir'  => [
        BASE_PATH . 'app/Http/Controllers',
        BASE_PATH . 'app/Listeners',
        BASE_PATH . 'app/Services/WebSocket',
        BASE_PATH . 'app/Dao',
    ],
    // 依赖绑定
    'bindings' => [
        'Psr\Http\Server\RequestHandlerInterface' => 'App\Http\Kernel',
        'Psr\Http\Message\ServerRequestInterface' => 'App\Lib\ServerRequest',
    ],
];
