<?php


namespace App\Http\Middlewares;

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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $stat = (int)$this->cache->get('stat');
            $this->cache->set('stat', ++$stat);
        } catch (\Exception $e) {
        }
        return $handler->handle($request);
    }
}
