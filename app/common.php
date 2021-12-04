<?php

/**
 * 用户自定义函数
 */

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

if (false === function_exists('api_success')) {
    /**
     * @param     $data
     * @param     $message
     * @param int $code
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws Throwable
     */
    function api_success($data, string $message, int $code = 0): \Psr\Http\Message\ResponseInterface
    {
        return \Max\Foundation\Http\Response::json([
            'data'    => $data,
            'message' => $message,
            'code'    => $code
        ]);
    }
}

if (false === function_exists('view')) {
    function view(string $template, array $arguments = [])
    {
        return make(\Max\View\Renderer::class)->render($template, $arguments);
    }
}
