<?php

namespace App\Http;

use Max\Di\Annotations\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller extends \Max\Foundation\Controller
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected ServerRequestInterface $request;
}
