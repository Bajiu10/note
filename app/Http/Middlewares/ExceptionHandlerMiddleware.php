<?php

namespace App\Http\Middlewares;

use Max\Console\Output\ConsoleOutput;
use Max\Di\Annotations\Inject;
use Max\Foundation\Http\Middlewares\ExceptionHandlerMiddleware as CoreExceptionHandlerMiddleware;
use Max\Http\Exceptions\HttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ExceptionHandlerMiddleware extends CoreExceptionHandlerMiddleware
{
    #[Inject]
    protected LoggerInterface $logger;
    #[Inject]
    protected ConsoleOutput   $output;

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
        $this->output->error($throwable::class . ':' . $throwable->getMessage() . ' at ' . $throwable->getFile() . '+' . $throwable->getLine());
        $this->output->warning($throwable->getTraceAsString());
        return view('error', ['code' => $this->getCode($throwable), 'message' => $throwable->getMessage()]);
    }
}