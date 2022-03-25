<?php

namespace App\Listeners;

use Max\Console\Output\ConsoleOutput;
use Max\Di\Annotations\Inject;
use Max\Event\Annotations\Listen;
use Max\Event\Contracts\EventListenerInterface;
use Max\Http\Exceptions\HttpException;
use Max\Server\Events\OnClose;
use Max\Server\Events\OnFinish;
use Max\Server\Events\OnMessage;
use Max\Server\Events\OnOpen;
use Max\Server\Events\OnRequest;
use Max\Server\Events\OnTask;

#[Listen]
class ServerListener implements EventListenerInterface
{
    /**
     * @var ConsoleOutput
     */
    #[Inject]
    protected ConsoleOutput $output;

    /**
     * @return iterable
     */
    public function listen(): iterable
    {
        return [
            OnTask::class,
            OnFinish::class,
            OnOpen::class,
            OnMessage::class,
            OnClose::class,
            OnRequest::class,
        ];
    }

    /**
     * @throws HttpException
     */
    public function process(object $event): void
    {
        $triggerTime = gmdate('Y-m-d H:i:s');

        switch (true) {
            case $event instanceof OnOpen:
                echo 'OnOpen: ' . $event->request->server['request_uri'], PHP_EOL;
                break;
            case $event instanceof OnMessage:
                echo 'OnMessage: ' . $event->frame->data . PHP_EOL;
                break;
            case $event instanceof OnClose:
                echo 'OnClose: ' . $event->fd . PHP_EOL;
                break;
            case $event instanceof OnRequest:
                $this->output->debug(sprintf("%s [%s]: %s [%s] %s",
                    $triggerTime,
                    $event::class,
                    $event->request->getMethod(),
                    $event->response->getStatusCode(),
                    $event->request->getUri()->__toString()
                ));
                break;
            case $event instanceof OnTask:
                $this->output->info('[DEBUG]');
                break;
        }
    }
}
