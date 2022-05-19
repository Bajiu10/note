<?php

namespace App\Services\WebSocket\Manager;

use App\Services\WebSocket\Room;
use App\Services\WebSocket\User;

class RoomManager
{
    protected array $rooms = [];

    public function add(Room $room)
    {
        $this->rooms[$room->getId()] = $room;
    }

    public function enterRoom($roomId, User $user)
    {
        $this->rooms[$roomId]->addUser($user);
    }

    public function getRoom($id)
    {
        return $this->rooms[$id] ?? null;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function count()
    {
        return count($this->rooms);
    }
}