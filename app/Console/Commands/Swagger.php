<?php

namespace App\Console\Commands;

use Max\Console\Commands\Command;

class Swagger extends Command
{
    /**
     * @var string
     */
    protected string $name = 'swagger';

    /**
     * @var string
     */
    protected string $description = 'Generate a swagger doc.';

    public function run()
    {
        $openapi = \OpenApi\Generator::scan([BASE_BATH . '/app/Http/Controllers']);
        file_put_contents($this->input->getOption('-o', BASE_BATH . '/swagger.json'), $openapi->toJson());
    }
}
