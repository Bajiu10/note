<?php

namespace App\Http\Controllers;

use App\Http\Controller;

class ApiController extends Controller
{
    /**
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return array
     */
    protected function success(array $data, string $message = '操作成功', int $code = 0): array
    {
        return [
            'status'  => true,
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return array
     */
    protected function error(string $message = '操作失败', array $data = [], int $code = 400): array
    {
        return [
            'status'  => false,
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ];
    }
}
