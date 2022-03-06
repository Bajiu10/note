<?php

namespace App\Listeners;

use Max\Event\Contracts\EventListenerInterface;
use Max\Server\Events\OnClose;
use Max\Server\Events\OnMessage;
use Max\Server\Events\OnOpen;

class WebSocketListener implements EventListenerInterface
{
    /**
     * @return iterable
     */
    public function listen(): iterable
    {
        return [
            OnOpen::class,
            OnMessage::class,
            OnClose::class,
        ];
    }

    /**
     * @param object $event
     */
    public function process(object $event): void
    {
        switch (true) {
            case $event instanceof OnOpen :
                echo 'OnOpen: ' . $event->request->server['request_uri'], PHP_EOL;
                break;
            case $event instanceof OnMessage:
                echo 'OnMessage: ' . $event->frame->data . PHP_EOL;
                break;
            case $event instanceof OnClose:
                echo 'OnClose: ' . $event->fd . PHP_EOL;
        }
    }
}
