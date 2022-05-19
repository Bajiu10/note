<?php


namespace App\Http\Middlewares;

use Exception;
use Max\Aop\Annotation\Inject;
use Max\Redis\Manager;
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
    protected Manager $redis;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->redis->incr('stat');
        } catch (Exception) {
        }
        return $handler->handle($request);
    }
}
