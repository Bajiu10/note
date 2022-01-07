<?php

return [
    //是否开启调试
    'debug'            => env('app.debug', false),
    //默认时区
    'default_timezone' => env('app.default_timezone', 'PRC'),
    'di'               => [
        // 开启注解
        'annotation' => true,
        //类别名
        'bindings'   => [
            'http'                                    => 'App\Http\Kernel',
            'console'                                 => 'App\Console\Kernel',
            'Psr\SimpleCache\CacheInterface'          => 'Max\Foundation\Cache',
            'Psr\Http\Message\ServerRequestInterface' => 'Max\Foundation\Http\Request',
            'Psr\Http\Message\ResponseInterface'      => 'Max\Foundation\Http\Response',
            'Psr\Log\LoggerInterface'                 => 'Max\Log\Logger',
            'Psr\Container\ContainerInterface'        => 'Max\Foundation\App',
        ],
    ],
    'url'              => 'https://www.1kmb.com',
    'theme'            => 'mt'
];
