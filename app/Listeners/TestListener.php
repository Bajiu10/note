<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Max\Event\Annotations\Listen;
use Max\Event\Contracts\EventListenerInterface;

#[Listen]
class TestListener implements EventListenerInterface
{
    /**
     * 该监听器监听的事件
     *
     * @return string[]
     */
    public function listen(): iterable
    {
        return [
            TestEvent::class,
        ];
    }

    /**
     * 触发事件的处理
     *
     * @param object $event
     */
    public function process(object $event): void
    {
        if ($event instanceof TestEvent) {
            var_dump($event->name);
        }
    }
}
