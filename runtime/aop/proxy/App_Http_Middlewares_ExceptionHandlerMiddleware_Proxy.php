<?php

namespace App\Http\Middlewares;

use Max\Console\Output\ConsoleOutput;
use Max\Aop\Annotation\Inject;
use Max\Http\Exceptions\HttpException;
use Max\Http\Middlewares\ExceptionHandlerMiddleware as CoreExceptionHandlerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use function view;
class ExceptionHandlerMiddleware extends CoreExceptionHandlerMiddleware
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct(protected \Psr\Http\Message\ResponseInterface $response)
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct(...func_get_args());
        }
        $this->__handleProperties();
    }
    #[Inject]
    protected ConsoleOutput $output;
    #[Inject]
    protected LoggerInterface $logger;
    /**
     * @param Throwable              $throwable
     * @param ServerRequestInterface $request
     *
     * @return void
     * @throws HttpException
     */
    protected function reportException(Throwable $throwable, ServerRequestInterface $request) : void
    {
        $this->logger->error($throwable->getMessage(), ['method' => $request->getMethod(), 'ip' => $request->ip(), 'uri' => $request->getUri()->__toString(), 'request' => $request->all(), 'headers' => $request->getHeaders(), 'file: ' => $throwable->getFile(), 'line: ' => $throwable->getLine(), 'code: ' => $throwable->getCode()]);
    }
    /**
     * @param Throwable              $throwable
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function renderException(Throwable $throwable, ServerRequestInterface $request) : ResponseInterface
    {
        if ($request->isAjax()) {
            return $this->response->json(['status' => false, 'message' => $throwable->getMessage(), 'data' => $throwable->getTrace(), 'code' => 500]);
        }
        $code = $throwable instanceof HttpException ? $throwable->getCode() : 500;
        return view('error', ['code' => $code, 'message' => $throwable->getMessage()])->withStatus($code);
    }
}