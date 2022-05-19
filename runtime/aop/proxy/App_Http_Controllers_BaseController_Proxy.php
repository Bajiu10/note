<?php

namespace App\Http\Controllers;

use Max\Aop\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
abstract class BaseController
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct()
    {
        $this->__handleProperties();
    }
    #[Inject]
    protected ContainerInterface $container;
    #[Inject]
    protected ServerRequestInterface $request;
    #[Inject]
    protected ResponseInterface $response;
}