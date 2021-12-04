<?php

namespace App\Http;

use App\Providers\AppServiceProvider;
use Max\Foundation\Http;

class Kernel extends Http
{
    /**
     * 中间件
     *
     * @var array
     */
    protected array $middleware = [
        \Max\Foundation\Http\Middleware\SessionInit::class,
        \App\Http\Middleware\Common\RateLimit::class,
        \App\Http\Middleware\Common\Statistic::class,
    ];

    protected array $middlewareGroups = [
        'api' => [],
        'web' => [],
    ];

    /**
     * 服务提供者
     *
     * @var string[]
     */
    protected array $providers = [
        \App\Providers\AppServiceProvider::class,
        \App\Providers\RouteServiceProvider::class,
        \Max\Cache\CacheServiceProvider::class,
    ];
}
