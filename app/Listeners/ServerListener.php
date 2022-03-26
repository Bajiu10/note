<?php

namespace App\Listeners;

use Max\Console\Output\ConsoleOutput;
use Max\Console\Output\Formatter;
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
                echo $triggerTime . '[' . $event::class . ']' . (new Formatter())->setForeground('blue')->apply($event->frame->data) . PHP_EOL;
                break;
            case $event instanceof OnClose:
                echo 'OnClose: ' . $event->fd . PHP_EOL;
                break;
            case $event instanceof OnRequest:
                $response = $event->response;
                $request  = $event->request;
                $code     = $response->getStatusCode();
                $method   = $request->getMethod();
                $uri      = $request->getUri()->__toString();
                echo $triggerTime . '[' . $event::class . ']' . (new Formatter())->setForeground($code == 200 ? 'green' : 'red')->apply(str_pad($code, 10, ' ', STR_PAD_BOTH)) . '|' . (new Formatter())->setForeground('blue')->apply(str_pad($method, 10, ' ', STR_PAD_BOTH)) . ' ' . (new Formatter())->setForeground('cyan')->apply(str_pad(round($event->duration * 1000, 4) . 'ms', 10, ' ', STR_PAD_RIGHT)) . $uri . PHP_EOL;
                break;
            case $event instanceof OnTask:
                $this->output->debug('[DEBUG]');
                break;
        }
    }
}
