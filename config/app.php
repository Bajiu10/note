<?php

return [
    //是否开启调试
    'debug'             => env('app.debug', false),
    //是否记录日志
    'log'               => env('app.log', true),
    //默认时区
    'default_timezone'  => env('app.default_timezone', 'PRC'),
    // 开启注解
    'annotation'        => true,
    //异常处理类
    'exception_handler' => \App\Exceptions\Handler::class,
    //类别名
    'aliases'           => [
        'console'                                       => \App\Console\Kernel::class,
        'http'                                          => \App\Http\Kernel::class,
        \Psr\SimpleCache\CacheInterface::class          => \Max\Cache\Cache::class,
        \Psr\Http\Message\ServerRequestInterface::class => \Max\Foundation\Http\Request::class,
        \Psr\Http\Message\ResponseInterface::class      => \Max\Foundation\Http\Response::class,
        \Psr\Log\LoggerInterface::class                 => \Max\Log\Logger::class,
        \Psr\Container\ContainerInterface::class        => \Max\Foundation\App::class,
    ],
    'app_url'           => 'https://www.1kmb.com',
    'theme'             => 'mt'
];
