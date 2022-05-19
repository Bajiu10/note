<?php

namespace App\Http\Middlewares;

use App\Services\TencentCloud\Captcha;
use Max\Aop\Annotation\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Http\Exceptions\InvalidRequestHandlerException;
use Max\Validator\Exceptions\ValidateException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;

class TencentCaptchaMiddleware implements MiddlewareInterface
{
    #[Inject]
    protected Captcha $captcha;

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws NotFoundException
     * @throws InvalidRequestHandlerException
     * @throws ContainerExceptionInterface
     * @throws ReflectionException|ValidateException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->captcha->valid($request)) {
            return $handler->handle($request);
        }
        throw new ValidateException('验证失败');
    }
}
