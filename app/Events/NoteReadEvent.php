<?php

namespace App\Events;

class NoteReadEvent
{
    public function __construct(public $id)
    {
    }
}
