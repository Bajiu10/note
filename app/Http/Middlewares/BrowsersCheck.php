<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BrowsersCheck implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (preg_match('/QQTheme|WeChat/', $request->server('HTTP_USER_AGENT') ?? '')) {
            abort('暂时不支持微信和QQ浏览器打开');
        }
        return $handler->handle($request);
    }
}
