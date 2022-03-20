<?php


namespace App\Http\Middlewares;

use Max\Di\Annotations\Inject;
use Max\Foundation\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Logined implements MiddlewareInterface
{
    #[Inject]
    protected Session $session;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userId = $this->session->get('user.id');
        if (!is_null($userId)) {
            throw new \Exception('你已经登录了！😊😊😊');
        }
        return $handler->handle($request);
    }
}
