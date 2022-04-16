<?php

namespace App\Services;

class ServerRequest extends \Max\Http\ServerRequest
{
    /**
     * 可以获取客户端真实ip
     *
     * @return string
     */
    public function ip(): string
    {
        if ($realIP = $this->getHeaderLine('X-Real-IP')) {
            return $realIP;
        }
        if ($forwardFor = $this->getHeaderLine('X-Forwarded-For')) {
            return $forwardFor;
        }
        return '127.0.0.1';
    }
}
