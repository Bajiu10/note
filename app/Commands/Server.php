<?php

namespace App\Commands;

use Max\Console\Commands\Command;
use Max\Console\Contracts\InputInterface;
use Max\Console\Contracts\OutputInterface;
use Max\Console\Output\ConsoleOutput;
use Max\Di\Exceptions\NotFoundException;
use Max\Server\Server as MaxSwooleServer;
use ReflectionException;

class Server extends Command
{
    /**
     * @var string
     */
    protected string $name = 'server';

    /**
     * @var string
     */
    protected string $description = 'Start swoole server.';

    /**
     * @param InputInterface $input
     * @param ConsoleOutput  $output
     *
     * @return void
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $server = new MaxSwooleServer(config('server'));
        $server->start();
    }
}
