<?php

use Max\Config\Repository;
use Max\Di\Exceptions\NotFoundException;
use Max\Env\Env;
use Max\Server\Http\Response;
use Max\View\Renderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

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
        $theme = config('app.theme');
        /** @var Renderer $renderer */
        $renderer = make(Renderer::class);
        ob_start();
        echo $renderer->render($theme . '.' . $template, $arguments);
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

if (!function_exists('time_convert')) {
    /**
     * @param $time
     *
     * @return string
     */
    function time_convert($time): string
    {
        if (is_null($time)) {
            return '暂无';
        }
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }
        $diff = time() - (int)$time;
        if ($diff < 60) {
            return '刚刚';
        }
        if ($diff < 3600) {
            return round($diff / 60) . '分钟前';
        }
        if ($diff < 86400) {
            return round($diff / 3600) . '小时前';
        }
        if ($diff < 86400 * 5) {
            return round($diff / 86400) . '天前';
        }
        return date('Y/n/j', $time);
    }
}

if (false === function_exists('format_size')) {
    /**
     * @param int $size
     *
     * @return string
     */
    function format_size(int $size)
    {
        if ($size < 1024) {
            return $size . 'B';
        } else if ($size < 1024 * 1024) {
            return round($size / 1024, 2) . 'KB';
        } else if ($size < 1024 * 1024 * 1024) {
            return round($size / 1024 / 1024, 2) . 'MB';
        }
    }
}

if (false === function_exists('get_url')) {
    /**
     * @param bool $full
     *
     * @return string
     * @throws NotFoundException
     * @throws ReflectionException
     */
    function get_url(bool $full = false): string
    {
        /** @var UriInterface $uri */
        $uri = make(\Psr\Http\Message\ServerRequestInterface::class)->getUri();
        return $uri->__toString();
    }
}
