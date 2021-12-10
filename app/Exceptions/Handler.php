<?php

namespace App\Exceptions;

use Max\Foundation\Exceptions\Handler as ExceptionHandler;
use Max\Foundation\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @param ServerRequestInterface $request
     * @param Throwable $throwable
     * @return ResponseInterface
     * @throws Throwable
     * @throws \Max\Foundation\Exceptions\HttpException
     */
    public function render(ServerRequestInterface $request, Throwable $throwable): ResponseInterface
    {
        if ($this->app->isDebug()) {
            return parent::render(...func_get_args());
        }
        return Response::make(view('mt/error', ['code' => $throwable->getCode(), 'message' => $throwable->getMessage()]));
    }
}
