<?php

namespace App\Console;

use Max\Foundation\Console\Kernel as ConsoleKernel;
use Max\Swoole\Server;

class Kernel extends ConsoleKernel
{
    /**
     * 命令
     *
     * @var array
     */
    protected array $commands = [
        'baidu'   => Commands\Baidu::class,
        'install' => Commands\Install::class,
        'sitemap' => Commands\Sitemap::class,
        'swoole'  => Server::class,
    ];

    /*
     * 服务提供者
     * @var array
     */
    protected array $providers = [
        \App\Providers\RouteServiceProvider::class,
    ];
}







