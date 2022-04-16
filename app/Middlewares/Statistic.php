<?php


namespace App\Middlewares;

use Exception;
use Max\Database\Redis;
use Max\Di\Annotations\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\CacheInterface;

class Statistic implements MiddlewareInterface
{
    #[Inject]
    protected CacheInterface $cache;

    #[Inject]
    protected Redis $redis;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->redis->incr('stat');
        } catch (Exception) {
        }
        return $handler->handle($request);
    }
}
