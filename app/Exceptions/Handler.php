<?php

namespace App\Exceptions;

use Max\Di\Annotations\Inject;
use Max\Server\Exceptions\HttpException;
use Max\Foundation\Http\Middlewares\HttpErrorHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class Handler extends HttpErrorHandler
{
    #[Inject]
    protected LoggerInterface $logger;

    /**
     * @param Throwable              $throwable
     * @param ServerRequestInterface $request
     *
     * @return void
     * @throws HttpException
     */
    protected function reportException(Throwable $throwable, ServerRequestInterface $request)
    {
        $this->logger->error($throwable->getMessage(), [
            'method'  => $request->getMethod(),
            'ip'      => $request->ip(),
            'uri'     => $request->getUri()->__toString(),
            'request' => $request->all(),
            'headers' => $request->getHeaders(),
            'file: '  => $throwable->getFile(),
            'line: '  => $throwable->getLine(),
            'code: '  => $throwable->getCode(),
        ]);
    }

    /**
     * @param Throwable              $throwable
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function renderException(Throwable $throwable, ServerRequestInterface $request): ResponseInterface
    {
        return view('error', ['code' => $this->getCode($throwable), 'message' => $throwable->getMessage()]);
    }
}
