<?php


namespace App\Http\Middleware\Common;

use Max\Foundation\Facades\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Logined implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userId = Session::get('user.id');
        if (!is_null($userId)) {
            throw new \Exception('你已经登录了！😊😊😊');
        }
        return $handler->handle($request);
    }
}
