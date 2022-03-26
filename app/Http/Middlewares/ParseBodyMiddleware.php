<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use Max\Http\Exceptions\HttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 自动请求编码方式为json的时候自动将json转为数组
 */
class ParseBodyMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws HttpException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->isValid($request)) {
            $body = $request->getBody()->getContents();
            $body = json_decode($body, true);
            $request->setPsr7($request->withParsedBody(array_replace_recursive($request->post(), $body)));
        }

        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     * @throws HttpException
     */
    protected function isValid(ServerRequestInterface $request): bool
    {
        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            return 0 === strcasecmp($request->getHeaderLine('Content-Type'), 'application/json');
        }
        return false;
    }
}
