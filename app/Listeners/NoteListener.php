<?php

namespace App\Listeners;

use App\Events\NoteReadEvent;
use App\Model\Entities\Note;
use Max\Database\Query\Expression;
use Max\Event\Annotations\Listen;
use Max\Event\Contracts\EventListenerInterface;

#[Listen]
class NoteListener implements EventListenerInterface
{
    public function listen(): iterable
    {
        return [
            NoteReadEvent::class,
        ];
    }

    public function process(object $event): void
    {
        if ($event instanceof NoteReadEvent) {
            Note::where('id', $event->id)->update(['hits' => new Expression('hits + 1')]);
        }
    }
}
