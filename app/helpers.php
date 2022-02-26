<?php

use Max\Config\Repository;
use Max\Di\Exceptions\NotFoundException;
use Max\Env\Env;
use Max\Server\Http\Response;
use Max\View\Renderer;
use Psr\Http\Message\ResponseInterface;

if (false === function_exists('base_path')) {
    /**
     * @param string $path
     *
     * @return string
     * @throws Exception
     */
    function base_path(string $path = ''): string
    {
        return BASE_BATH . ltrim($path, '/');
    }
}

if (false === function_exists('env')) {
    /**
     * env获取
     *
     * @param string|null $key
     * @param null        $default
     *
     * @return mixed
     * @throws Exception
     */
    function env(string $key = null, $default = null): mixed
    {
        return make(Env::class)->get($key, $default);
    }
}

if (false === function_exists('view')) {
    /**
     * @param string $template
     * @param array  $arguments
     *
     * @return ResponseInterface
     * @throws Throwable
     */
    function view(string $template, array $arguments = []): ResponseInterface
    {
        /** @var Renderer $renderer */
        $renderer = make(Renderer::class);
        ob_start();
        echo $renderer->render($template, $arguments);
        return (new Response())->html(ob_get_clean());
    }
}

if (false === function_exists('config')) {
    /**
     *配置文件获取辅助函数
     *
     * @param string|null $key     配置Key
     * @param null        $default 默认值
     *
     * @return mixed
     * @throws NotFoundException
     * @throws ReflectionException
     */
    function config(string $key = null, $default = null): mixed
    {
        /** @var Repository $config */
        $config = make(Repository::class);

        return $key ? $config->get($key, $default) : $config->all();
    }
}

if (false === function_exists('session')) {
    function session(string $key, $value = null)
    {
        /** @var \Max\Session\Session $session */
        $session = make(\Max\Session\Session::class);
        if (is_null($value)) {
            return $session->get($key);
        }
        $session->set($key, $value);
    }
}

if (false === function_exists('request')) {
    function request()
    {
        return make(\Psr\Http\Message\ServerRequestInterface::class);
    }
}

if (false === function_exists('redirect')) {
    function redirect(string $url, int $code = 302)
    {
        /** @var ResponseInterface $response */
        $response = make(ResponseInterface::class);
        return $response
            ->withHeader('Location', $url)
            ->withStatus($code);
    }
}

