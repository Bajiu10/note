<?php

namespace App\Exceptions;

use Max\Foundation\Exceptions\HttpException;
use Max\Foundation\Http\Middleware\HttpErrorHandler;
use Max\Foundation\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * @class   Handler
 * @author  ChengYao
 * @date    2021/12/18
 * @time    13:00
 * @package App\Exceptions
 */
class Handler extends HttpErrorHandler
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Throwable             $throwable
     * @param ServerRequestInterface $request
     *
     * @return void
     */
    protected function reportException(Throwable $throwable, ServerRequestInterface $request)
    {
        $this->logger->error($throwable->getMessage(), [
            'Method'  => $request->getMethod(),
            'Uri'     => $request->getUri()->__toString(),
            'Request' => $request->all(),
            'Headers' => $request->getHeaders(),
            'File: '  => $throwable->getFile(),
            'Line: '  => $throwable->getLine(),
            'Code: '  => $throwable->getCode(),
        ]);
    }

    /**
     * @param Throwable             $throwable
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws HttpException
     * @throws Throwable
     */
    protected function renderException(Throwable $throwable, ServerRequestInterface $request): ResponseInterface
    {
        if (app()->isDebug()) {
            return parent::renderException(...func_get_args());
        }
        if ($request->isAjax()) {
            return Response::make([
                'status'  => false,
                'code'    => 1000,
                'data'    => $throwable->getTrace(),
                'message' => $throwable->getMessage(),
            ]);
        }
        return Response::make(view('mt.error', [
            'message' => $throwable->getMessage(),
            'code'    => $throwable->getCode(),
        ]), [], $this->getCode($throwable));
    }
}
