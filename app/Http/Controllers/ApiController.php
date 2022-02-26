<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use Psr\Http\Message\ResponseInterface;

class ApiController extends Controller
{
    /**
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return ResponseInterface
     */
    protected function success(array $data, string $message = '操作成功', int $code = 0): ResponseInterface
    {
        return $this->response->json([
            'status'  => true,
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ]);
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return ResponseInterface
     */
    protected function error(string $message = '操作失败', array $data = [], int $code = 400):ResponseInterface
    {
        return $this->response->json([
            'status'  => false,
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ]);
    }
}
