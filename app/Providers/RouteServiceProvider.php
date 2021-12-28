<?php

namespace App\Providers;

use Max\Foundation\Providers\RouteServiceProvider as RouteProvider;
use Max\Routing\Router;

class RouteServiceProvider extends RouteProvider
{
	public function map(Router $router) {
		$router->group(function() {
			require route_path('web.php');
		});
	}
}
