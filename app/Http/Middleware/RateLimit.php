<?php

namespace App\Http\Middleware;

use Max\Foundation\Facades\Cache;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RateLimit implements MiddlewareInterface
{
    /**
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $ip   = $request->ip();
        $freq = (int)Cache::get($ip) ?? 0;
        //这里的3和第24行的1 表示1秒钟最多请求3次
        if ($freq > 5) {
            if (99 != $freq) {
                //这里的5表示超过限制的频率会被限制访问5秒
                Cache::set($ip, 99, 5);
            }
            throw new \Exception('刷新太快了！');
        }
        Cache::set($ip, ++$freq, 1);
        return $handler->handle($request);
    }
}
