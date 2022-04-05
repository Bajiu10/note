<?php

namespace App\Listeners;

use Max\Foundation\Aspects\Cacheable;

class AspectCollectListener extends \Max\Di\Listeners\AspectCollectListener
{
    public function listen(): iterable
    {
        return [
            Cacheable::class,
        ];
    }
}
