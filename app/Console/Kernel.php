<?php

namespace App\Console;

use Max\Foundation\Console\Kernel as ConsoleKernel;

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
        'swoole'  => \Max\Swoole\Server::class,
    ];

    /*
     * 服务提供者
     * @var array
     */
    protected array $providers = [
        \App\Providers\RouteServiceProvider::class,
    ];
}







