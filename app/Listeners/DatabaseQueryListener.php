<?php

namespace App\Listeners;

use Max\Database\Events\QueryExecuted;
use Max\Di\Annotations\Inject;
use Max\Event\Contracts\EventListenerInterface;
use Max\Foundation\Annotations\Listen;
use Max\Log\LoggerFactory;

#[Listen]
class DatabaseQueryListener implements EventListenerInterface
{
    /**
     * @var LoggerFactory
     */
    #[Inject]
    protected LoggerFactory $loggerFactory;

    /**
     * @return iterable
     */
    public function listen(): iterable
    {
        return [
            QueryExecuted::class,
        ];
    }

    /**
     * @param object $event
     */
    public function process(object $event): void
    {
        if ($event instanceof QueryExecuted) {
            $this->loggerFactory->get('sql')->debug($event->query, [
                'duration' => round($event->duration, 6) * 1000 . 'ms',
                'bindings' => $event->bindings,
            ]);
        }
    }
}
