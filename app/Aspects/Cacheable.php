<?php

namespace App\Aspects;

use Closure;
use Max\Di\Aop\JoinPoint;
use Max\Di\Contracts\AspectInterface;
use Max\Di\Exceptions\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\SimpleCache\CacheInterface;
use ReflectionException as ReflectionExceptionAlias;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Cacheable implements AspectInterface
{
    /**
     * @var CacheInterface|mixed
     */
    protected CacheInterface $cache;

    /**
     * @param int $ttl
     * @param string|null $key
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws ReflectionExceptionAlias
     */
    public function __construct(protected int $ttl = 0, protected ?string $key = null)
    {
        $this->cache = make(CacheInterface::class);
    }

    /**
     * @param JoinPoint $joinPoint
     * @param Closure $next
     * @return mixed
     */
    public function process(JoinPoint $joinPoint, Closure $next)
    {
        $key = $this->key ?? serialize([$joinPoint->getProxy()::class, $joinPoint->getMethod(), $joinPoint->getArguments()]);
        return $this->cache->remember($key, function () use ($next, $joinPoint) {
            return $next($joinPoint);
        }, $this->ttl);
    }
}