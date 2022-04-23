<?php

return [
    'scanDir'  => [
        BASE_PATH . 'app',
    ],
    // 依赖绑定
    'bindings' => [
        'Psr\Http\Server\RequestHandlerInterface' => 'App\Kernel',
        'Psr\Http\Message\ServerRequestInterface' => 'App\Services\ServerRequest',
    ],
];
