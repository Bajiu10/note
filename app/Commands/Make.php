<?php
declare(strict_types=1);

namespace App\Commands;

use Exception;
use Max\Console\Commands\Command;
use Max\Console\Contracts\InputInterface;
use Max\Console\Contracts\OutputInterface;
use Max\Console\Exceptions\InvalidOptionException;
use Max\Console\Input\ArgvInput;
use Max\Console\Output\ConsoleOutput;
use Max\Utils\Filesystem;

class Make extends Command
{
    /**
     * @var string
     */
    protected string $name = 'make';

    /**
     * @var string
     */
    protected string $description = 'Create files in command line';

    /**
     * @var string
     */
    protected string $help = "-c  <controller> [--rest]                   Create a controller file (php max make -c index/index)
                                                Use [--rest] to create a restful controller
-mw <middleware>                            Create a middleware file (php max make -mw UACheck)";

    /**
     * @var string
     */
    protected string $skeletonPath = __DIR__ . '/../Commands/skeleton/';

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws InvalidOptionException
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasArgument('--help') || $input->hasArgument('-H')) {
            echo $this->getHelp();
        }
        if ($input->hasOption('-c')) {
            return $this->makeController($input, $output);
        }
        if ($input->hasOption('-mw')) {
            return $this->makeMiddleware($input, $output);
        }
        throw new InvalidOptionException('Use `php max make --help` or `php max make -H` to look up for usable options.');
    }

    /**
     * @param ArgvInput     $input
     * @param ConsoleOutput $output
     *
     * @return mixed
     * @throws Exception
     */
    public function makeController($input, $output)
    {
        $file = $this->skeletonPath . ($input->hasArgument('--rest') ? 'controller_rest.tpl' : 'controller.tpl');
        [$namespace, $controller] = $this->parse($input->getOption('-c'));

        $path           = base_path('app/Http/Controllers/' . str_replace('\\', '/', $namespace) . '/');
        $fileSystem     = new Filesystem();
        $controllerFile = $path . $controller . '.php';
        if ($fileSystem->exists($controllerFile)) {
            $output->warning('控制器已经存在!', ConsoleOutput::STYLE_RB);
            return;
        }

        $fileSystem->exists($path) || $fileSystem->makeDirectory($path, 0777, true);

        $file = str_replace(['{{namespace}}', '{{class}}'], ['App\\Http\\Controllers' . $namespace, $controller], $fileSystem->get($file));
        $fileSystem->put($path . $controller . '.php', $file);
        $output->info("控制器App\\Http\\Controllers{$namespace}\\{$controller}创建成功！", ConsoleOutput::STYLE_GB);
    }

    /**
     * @param ArgvInput     $input
     * @param ConsoleOutput $output
     *
     * @return mixed
     * @throws Exception
     */
    public function makeMiddleware($input, $output)
    {
        $file = $this->skeletonPath . 'middleware.tpl';
        [$namespace, $middleware] = $this->parse($input->getOption('-mw'));
        $stream = str_replace(['{{namespace}}', '{{class}}'], ['App\\Http\\Middlewares' . $namespace, $middleware], file_get_contents($file));
        $path   = base_path('app/Http/Middlewares/' . str_replace('\\', '/', $namespace) . '/');
        Filesystem::exists($path) || Filesystem::makeDirectory($path, 0777, true);
        file_put_contents($path . $middleware . '.php', $stream);
        return $output->write("中间件App\\Http\\Middlewares{$namespace}\\{$middleware}创建成功！", ConsoleOutput::STYLE_GB);
    }

    /**
     * @param $input
     *
     * @return array
     */
    protected function parse($input)
    {
        $array     = explode('/', $input);
        $class     = ucfirst(array_pop($array));
        $namespace = implode('\\', array_map(function ($value) {
            return ucfirst($value);
        }, $array));
        if (!empty($namespace)) {
            $namespace = '\\' . $namespace;
        }
        return [$namespace, $class];
    }
}
