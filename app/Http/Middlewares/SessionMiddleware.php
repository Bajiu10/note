<?php

namespace App\Http\Middlewares;

use Max\Foundation\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    /**
     * @var Session
     */
    protected Session $session;

    /**
     * @var string|array|mixed|null
     */
    protected string $name = 'MAXPHP_SESSION_ID';

    /**
     * Cookie 过期时间
     *
     * @var array|mixed|null
     */
    protected int $cookieExpires = 3600;

    protected bool $httponly = true;

    protected bool $secure = true;

    protected array $cookieOptions = [
        'expires'  => 3600,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
        'httponly' => false,
        'samesite' => '',
    ];

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $id = $request->getCookieParams()[$this->name] ?? $this->session->refreshId();
        $this->session->initialize($id);
        $response = $handler->handle($request);
        $this->session->save();
        // TODO这个cookie过期时间有问题
        $expires = time() + $this->cookieExpires;
        return $response->withAddedHeader('Set-Cookie', "$this->name=$id; expires=$expires");
    }
}
