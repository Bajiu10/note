<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
abstract class ApiBaseController extends BaseController
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct()
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct(...func_get_args());
        }
        $this->__handleProperties();
    }
    /**
     * @param array |\JsonSerializable $data
     * @param string                   $message
     * @param int                      $code
     *
     * @return ResponseInterface
     */
    protected function success($data, string $message = '操作成功', int $code = 0) : ResponseInterface
    {
        $response = $this->response->json(['status' => true, 'code' => $code, 'data' => $data, 'message' => $message]);
        $this->response->setPsr7($response);
        return $this->response;
    }
    /**
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return ResponseInterface
     */
    protected function error(string $message = '操作失败', array $data = [], int $code = 400) : ResponseInterface
    {
        $response = $this->response->json(['status' => false, 'code' => $code, 'data' => $data, 'message' => $message]);
        $this->response->setPsr7($response);
        return $this->response;
    }
}