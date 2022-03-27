<?php

namespace App\Services\WebSocket;

class User
{
    protected string $username = '匿名用户';

    public function __construct(protected int $id = 0)
    {
    }

    public function getId()
    {
        return $this->id;
    }
}