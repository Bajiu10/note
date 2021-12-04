<?php

namespace App\Console\Commands;

use Max\Console\Command;
use Max\Foundation\Facades\DB;

class Sitemap extends Command
{

    protected $name = 'baidu';

    protected $description = '生成sitemap';

    public function handle()
    {
        $notes   = DB::name('notes')->fields(['create_time', 'id'])->select();
        $sitemap = "<urlset>";
        foreach ($notes as $note) {
            $sitemap .= <<<TOR

    <url>
        <loc>https://www.chengyao.xyz/note/{$note['id']}.html</loc>
        <priority>1.00</priority>
        <lastmod>{$note['create_time']}</lastmod>
        <changefreq>Always</changefreq>
    </url>
TOR;
        }
        $sitemap .= "\n</urlset>";
        if (false !== file_put_contents(env('public_path') . 'sitemap.xml', $sitemap)) {
            return $this->output->info('Sitemap生成成功，共' . $notes->count() . '条！');
        }
    }

}
