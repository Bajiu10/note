<?php

namespace App\Http\Middlewares;

use Max\Aop\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\CacheInterface;

class RateLimit implements MiddlewareInterface
{
    #[Inject]
    protected CacheInterface $cache;

    /**
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $ip   = $request->ip();
        $freq = (int)$this->cache->get($ip) ?? 0;
        //这里的3和第24行的1 表示1秒钟最多请求3次
        if ($freq > 5) {
            if (99 != $freq) {
                //这里的5表示超过限制的频率会被限制访问5秒
                $this->cache->set($ip, 99, 5);
            }
            throw new \Exception('刷新太快了！');
        }
        $this->cache->set($ip, ++$freq, 1);
        return $handler->handle($request);
    }
}
