<?php

namespace App\Services\TencentCloud;

use Max\Config\Annotations\Config;
class User
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct()
    {
        $this->__handleProperties();
    }
    /**
     * @var string
     */
    #[Config(key: 'services.qcloud.user.secret_key')]
    protected string $secretKey;
    /**
     * @var string
     */
    #[Config(key: 'services.qcloud.user.secret_id')]
    protected string $secretId;
    /**
     * @return string
     */
    public function getSecretKey() : string
    {
        return $this->secretKey;
    }
    /**
     * @return string
     */
    public function getSecretId() : string
    {
        return $this->secretId;
    }
}