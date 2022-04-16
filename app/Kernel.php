<?php

namespace App;

use Max\Http\RequestHandler;
use Max\Routing\Router;

class Kernel extends RequestHandler
{
    /**
     * 全局中间件
     *
     * @var array|string[]
     */
    protected array $middlewares = [
        'App\Middlewares\ExceptionHandlerMiddleware',
        'App\Middlewares\SessionMiddleware',
        'Max\Http\Middlewares\RoutingMiddleware',
        'App\Middlewares\AllowCrossDomain',
        'App\Middlewares\ParseBodyMiddleware',
        'App\Middlewares\Statistic'
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
