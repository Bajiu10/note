<?php

namespace App\Commands;

use Max\Console\Commands\Command;
use Max\Console\Contracts\InputInterface;
use Max\Console\Contracts\OutputInterface;
use Max\Di\Exceptions\NotFoundException;
use ReflectionException;
use Throwable;

class Queue extends Command
{
    /**
     * @var string
     */
    protected string $name = 'queue:work';

    /**
     * @var string
     */
    protected string $description = 'Start the queue';

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $queue = new \Max\Queue\Queue(config('queue'));
        $queue->work($input->getOption('--queue') ?? null);
    }
}
