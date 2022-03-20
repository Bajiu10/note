<?php

namespace App\Http\Middlewares;

use Max\Di\Annotations\Inject;
use Max\Foundation\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Login implements MiddlewareInterface
{
    #[Inject]
    protected Session $session;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userId = $this->session->get('user.id');
        if (!is_null($userId)) {
            return $handler->handle($request);
        }
        throw new \Exception('你还没有登录哦！😢😢😢');
    }

}
