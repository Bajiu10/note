<?php

namespace App\Listeners;

use Max\Event\Contracts\EventListenerInterface;
use Max\Server\Events\OnRequest;

class HttpListener implements EventListenerInterface
{
    /**
     * @return iterable
     */
    public function listen(): iterable
    {
        return [
            OnRequest::class,
        ];
    }

    /**
     * @param object $event
     */
    public function process(object $event): void
    {
        $eventName   = get_class($event);
        $triggerTime = gmdate('Y-m-d H:i:s');

        if ($event instanceof OnRequest) {
            echo sprintf("%s [%s]: %s [%s] %s\n",
                $triggerTime,
                $eventName,
                $event->request->getMethod(),
                $event->response->getStatusCode(),
                $event->request->getUri()->__toString()
            ), PHP_EOL;
        }
    }
}
