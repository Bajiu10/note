<?php

namespace App\Exceptions;

use Max\Foundation\App;
use Max\Foundation\Exceptions\Handler as ExceptionHandler;
use Max\Foundation\Exceptions\HttpException;
use Max\Foundation\Http\Response;
use Max\Log\LoggerFactory;
use Max\Routing\Exceptions\RouteNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class Handler extends ExceptionHandler
{

    protected LoggerFactory $loggerFactory;

    public function __construct(App $app)
    {
        parent::__construct($app);
        /** @var LoggerFactory $loggerFactory */
        $this->loggerFactory = $app->make(LoggerFactory::class);
    }


    /**
     * @param ServerRequestInterface $request
     * @param Throwable $throwable
     *
     * @return ResponseInterface
     * @throws Throwable
     * @throws \Max\Foundation\Exceptions\HttpException
     */
    public function render(ServerRequestInterface $request, Throwable $throwable): ResponseInterface
    {
        if ($this->app->isDebug()) {
            return parent::render(...func_get_args());
        }
        $this->loggerFactory->get('business')->info(
            $throwable->getMessage(), [
            'request' => $request->all(),
        ]);
        return Response::make(view('mt/error', ['code' => $throwable->getCode(), 'message' => $throwable->getMessage()]), [], $throwable instanceof HttpException || $throwable instanceof RouteNotFoundException ? $throwable->getCode() : 500);
    }
}
