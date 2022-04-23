<?php

namespace App\Controllers;

use Max\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected ServerRequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;
}
