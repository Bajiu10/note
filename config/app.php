<?php

return [
    'di'    => [
        // 依赖绑定
        'bindings' => [
            \Psr\Http\Message\ServerRequestInterface::class => \App\Lib\ServerRequest::class,
        ],
    ],
    'event' => [
        // 注解扫描路径
        'scanDir' => [
            __DIR__ . '/../app/Listeners',
        ]
    ],
    'theme' => 'mt'
];
