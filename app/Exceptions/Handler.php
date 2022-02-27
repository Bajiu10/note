<?php

namespace App\Exceptions;

use Max\Di\Annotations\Inject;
use Max\Server\Http\Middlewares\HttpErrorHandler;
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
     */
    protected function reportException(Throwable $throwable, ServerRequestInterface $request)
    {
        $this->logger->error($throwable->getMessage(), [
            'method'  => $request->getMethod(),
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
        echo $throwable->getMessage(), PHP_EOL, $throwable->getTraceAsString();
        return view('mt.error', ['code' => $this->getCode($throwable), 'message' => $throwable->getMessage()]);
    }
}
