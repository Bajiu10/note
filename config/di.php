<?php

return [
    'scanDir'  => [
        BASE_PATH . 'app/Controllers',
        BASE_PATH . 'app/Listeners',
        BASE_PATH . 'app/Model/Dao',
    ],
    // 依赖绑定
    'bindings' => [
        'Psr\Http\Server\RequestHandlerInterface' => 'App\Kernel',
        'Psr\Http\Message\ServerRequestInterface' => 'App\Services\ServerRequest',
    ],
];
