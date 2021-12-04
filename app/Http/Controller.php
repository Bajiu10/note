<?php

namespace App\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller extends \Max\Foundation\Controller
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(ContainerInterface $container, ServerRequestInterface $request)
    {
        $this->container = $container;
        $this->request   = $request;
    }
}
