<?php

return [
    'di'    => [
        // 依赖绑定
        'bindings' => [
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
