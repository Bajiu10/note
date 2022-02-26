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

if (false === function_exists('get_url')) {
    /**
     * @param bool $full
     *
     * @return string
     */
    function get_url(bool $full = false): string
    {
        /** @var \Psr\Http\Message\UriInterface $uri */
        $uri = make(\Psr\Http\Message\ServerRequestInterface::class)->getUri();
        return $uri->__toString();
    }
}
