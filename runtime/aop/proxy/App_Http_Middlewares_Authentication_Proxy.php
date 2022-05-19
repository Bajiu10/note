<?php

namespace App\Http\Middlewares;

use Exception;
use Max\Aop\Annotation\Inject;
use Max\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
class Authentication implements MiddlewareInterface
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct()
    {
        $this->__handleProperties();
    }
    #[Inject]
    protected Session $session;
    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $userId = $this->session->get('user.id');
        if (!is_null($userId)) {
            return $handler->handle($request);
        }
        throw new Exception('你还没有登录哦！😢😢😢');
    }
}