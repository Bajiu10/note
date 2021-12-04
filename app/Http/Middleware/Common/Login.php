<?php

namespace App\Http\Middleware\Common;

use Max\Foundation\Facades\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Login implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userId = Session::get('user.id');
        if (!is_null($userId)) {
            return $handler->handle($request);
        }
        throw new \Exception('你还没有登录哦！😢😢😢');
    }

}
