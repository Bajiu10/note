<?php

namespace App\Http;

use App\Http\Middleware\AllowCrossDomain;
use App\Http\Middleware\RateLimit;
use App\Http\Middleware\Statistic;
use Max\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 中间件
     *
     * @var array
     */
    protected array $middleware = [
        //        RateLimit::class,
        Statistic::class,
    ];

    protected array $middlewareGroups = [
        'api' => [
            AllowCrossDomain::class,
        ],
        'web' => [
            \Max\Foundation\Http\Middleware\SessionInit::class,
        ],
    ];

    /**
     * 服务提供者
     *
     * @var string[]
     */
    protected array $providers = [
        \App\Providers\AppServiceProvider::class,
        \App\Providers\RouteServiceProvider::class,
    ];
}
