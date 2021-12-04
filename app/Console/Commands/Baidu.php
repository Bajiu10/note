<?php

namespace App\Console\Commands;

use Max\Console\Command;
use Max\Foundation\Facades\DB;

class Baidu extends Command
{
    public function handle()
    {
        $ids  = DB::name('notes')->column('id');
        $urls = [];
        foreach ($ids as $id) {
            $urls[] = 'https://www.chengyao.xyz/note/' . $id . '.html';
        }
        $api     = 'http://data.zz.baidu.com/urls?site=https://www.chengyao.xyz&token=' . config('baidu.key');
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
        return $this->output->info($result);
    }

}
