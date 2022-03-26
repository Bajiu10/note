<?php

namespace App\Http;

use Max\Foundation\Http\RequestHandler;
use Max\Routing\Router;

class Kernel extends RequestHandler
{
    /**
     * 全局中间件
     *
     * @var array|string[]
     */
    protected array $middlewares = [
        'App\Http\Middlewares\ExceptionHandlerMiddleware',
        'App\Http\Middlewares\SessionMiddleware',
        'Max\Foundation\Http\Middlewares\RoutingMiddleware',
        'App\Http\Middlewares\AllowCrossDomain',
        'App\Http\Middlewares\ParseBodyMiddleware',
        'App\Http\Middlewares\Statistic'
    ];

    /**
     * 路由扫描路径
     *
     * @var array|string[]
     */
    protected array $routeScanDir = [
        __DIR__ . '/Controllers'
    ];

    /**
     * 注册路由
     *
     * @param Router $router
     */
    protected function map(Router $router)
    {
    }
}
