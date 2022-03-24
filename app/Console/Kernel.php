<?php

namespace App\Console;

use Max\Foundation\Console\Application;

class Kernel extends Application
{
    /**
     * 命令扫描路径
     *
     * @var array|string[]
     */
    protected array $scanDir = [
        __DIR__ . '/Commands',
    ];
}
