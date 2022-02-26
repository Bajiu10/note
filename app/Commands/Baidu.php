<?php

namespace App\Commands;

use Max\Config\Annotations\Config;
use Max\Console\Commands\Command;
use Max\Console\Contracts\InputInterface;
use Max\Console\Contracts\OutputInterface;
use Max\Database\Query;
use Max\Di\Annotations\Inject;

class Baidu extends Command
{
    /**
     * @var string
     */
    protected string $name = 'baidu:push';

    #[Inject]
    protected Query $query;

    #[Config(key: 'app.url', default: '')]
    protected string $url;

    #[Config(key: 'baidu.key', default: '')]
    protected string $baiduKey;

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $ids  = $this->query->table('notes')->column('id');
        $urls = [];
        foreach ($ids as $id) {
            $urls[] = $this->url . '/note/' . $id . '.html';
        }
        $api     = 'http://data.zz.baidu.com/urls?site=' . $this->url . '&token=' . $this->baiduKey;
        $ch      = curl_init();
        $options = array(
            CURLOPT_URL            => $api,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => implode("\n", $urls),
            CURLOPT_HTTPHEADER     => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        if (false == $result) {
            exit(curl_error($ch));
        }
        return $output->info($result);
    }
}
