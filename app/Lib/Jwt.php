<?php

namespace App\Lib;

use Firebase\JWT\Key;
use Max\Config\Annotations\Config;

class Jwt
{
    #[Config(key: 'auth.jwt.privateKey')]
    protected string $privateKey;

    #[Config(key: 'auth.jwt.publicKey')]
    protected string $publicKey;

    public function encode($payload)
    {
        return \Firebase\JWT\JWT::encode($payload, $this->privateKey, 'RS256');
    }

    public function decode($token)
    {
        return \Firebase\JWT\JWT::decode($token, new Key($this->publicKey, 'RS256'));
    }
}
