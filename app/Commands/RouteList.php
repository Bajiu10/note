<?php
declare(strict_types=1);

namespace App\Commands;

use Exception;
use Max\Console\{Contracts\InputInterface, Contracts\OutputInterface};
use Max\Console\Commands\Command;
use Max\Routing\Route;
use Max\Routing\RouteCollector;
use Max\Utils\Collection;

class RouteList extends Command
{
    /**
     * @var string
     */
    protected string $name = 'route:list';

    /**
     * @var string
     */
    protected string $description = 'List your routers';

    protected const SEPARATOR = "+---------------------------+------------------------------------------------------------+---------------------------------------------+----------------+\n";

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Exception
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        make(\Max\Server\Http\Server::class);
        echo self::SEPARATOR . "|" . $this->format(' METHODS', 26) . " |" . $this->format('URI', 60) . "|" . $this->format('DESTINATION', 45) . "|  " . "|\n" . self::SEPARATOR;
        foreach ($this->getRoutes() as $route) {
            /** @var Route $route */
            $action = $route->getAction();
            if (is_array($action)) {
                $action = implode('@', $action);
            } else if ($action instanceof \Closure) {
                $action = '\Closure';
            }
            echo '|' . $this->format(strtoupper(implode('|', $route->getMethods())), 27) . '|' . $this->format($route->getPath(), 60) . '|' . $this->format($action, 45) . '| ' . "|\n";
        }
        echo self::SEPARATOR;
    }

    /**
     * @return Collection
     */
    protected function getRoutes(): Collection
    {
        /** @var RouteCollector $routeCollector */
        $routeCollector = make(RouteCollector::class);
        $routeCollector->compile();;
        $routes = [];
        foreach ($routeCollector->all() as $registeredRoute) {
            foreach ($registeredRoute as $method => $route) {
                if (!in_array($route, $routes)) {
                    $routes[] = $route;
                }
            }
        }
        return collect($routes)->unique()->sortBy(function ($item) {
            /** @var Route $item */
            return $item->getPath();
        });
    }

    /**
     * 格式化文本，给两端添加空格
     *
     * @param $string
     * @param $length
     *
     * @return string
     */
    private function format($string, $length): string
    {
        return str_pad($string, $length, ' ', STR_PAD_BOTH);
    }
}
