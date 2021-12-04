<?php

namespace App\Providers;

use Max\Foundation\Facades\Route;
use Max\Foundation\Providers\RouteServiceProvider as RouteProvider;

class RouteServiceProvider extends RouteProvider
{
    /**
     * 注册路由
     *
     * @throws \Exception
     */
    public function map()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(env('route_path') . 'api.php');
        Route::middleware('web')
             ->group(env('route_path') . 'web.php');
    }
}
