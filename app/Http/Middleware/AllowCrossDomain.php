<?php

namespace App\Http\Middleware;

use Max\Foundation\Http\Middleware\AllowCrossDomain as AllowCross;

/**
 * Class Cors
 *
 * @package App\Http\Middleware
 */
class AllowCrossDomain extends AllowCross
{
    /**
     * 全局跨域
     *
     * @var bool
     */
    protected bool $global = false;

    /**
     * 允许跨的域
     *
     * @var array
     */
    protected array $allowOrigin = [

    ];

}
