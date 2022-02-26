<?php

namespace App\Lib\Http;

class Response extends \Max\Server\Http\Response
{
    public static function error(string $message, $data = [], $code = 400)
    {
        return (new static())->json([
            'status'  => false,
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ]);
    }
}
