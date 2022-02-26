<?php

namespace App\Commands;

use Max\Console\Commands\Command;
use Max\Console\Contracts\InputInterface;
use Max\Console\Contracts\OutputInterface;
use Max\Console\Output\ConsoleOutput;
use Throwable;

class VendorPublish extends Command
{
    /**
     * @var string
     */
    protected string $name = 'vendor:publish';

    /**
     * @var string
     */
    protected string $description = 'Publish publishable packages';

    /**
     * @param InputInterface $input
     * @param ConsoleOutput  $output
     *
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $path      = getcwd();
        $installed = json_decode(file_get_contents($path . '/vendor/composer/installed.json'), true);
        $installed = $installed['packages'] ?? $installed;
        $config    = [];
        foreach ($installed as $package) {
            if (isset($package['extra']['max']['config'])) {
                $configProvider = $package['extra']['max']['config'];
                $configProvider = new $configProvider;
                if (method_exists($configProvider, '__invoke')) {
                    if (is_array($configItem = $configProvider())) {
                        $config = array_merge_recursive($config, $configItem);
                    }
                }
                if (method_exists($configProvider, 'publish')) {
                    try {
                        $configProvider->publish();
                        $output->info('Publish successfully.');
                    } catch (Throwable $throwable) {
                        $output->error($throwable->getMessage());
                    }
                }
            }
        }
        $path .= '/storage/app/';
        file_exists($path) || mkdir($path);
        file_put_contents($path . 'config.php', sprintf("<?php\n\nreturn %s;", var_export($config, true)));
        $output->writeLine('');
    }
}
