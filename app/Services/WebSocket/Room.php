<?php

namespace App\Services\WebSocket;

class Room
{
    protected array $users = [];

    protected string $logo;

    public function __construct(protected int $id)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function addUser(User $user)
    {
        $this->users[$user->getId()] = $user;
    }

}