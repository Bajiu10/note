<?php

namespace App\Services\TencentCloud;

use Max\Config\Annotations\Config;

class User
{
    /**
     * @var string
     */
    #[Config(key: 'qcloud.user.secret_key')]
    protected string $secretKey;
    /**
     * @var string
     */
    #[Config(key: 'qcloud.user.secret_id')]
    protected string $secretId;

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getSecretId(): string
    {
        return $this->secretId;
    }

}
