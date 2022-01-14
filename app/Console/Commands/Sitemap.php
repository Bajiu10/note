<?php

namespace App\Console\Commands;

use Max\Console\Command;
use Max\Foundation\Facades\DB;

class Sitemap extends Command
{
    /**
     * @var string
     */
    protected $name = 'baidu';
    /**
     * @var string
     */
    protected $description = '生成sitemap';

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $notes   = DB::table('notes')->get(['create_time', 'id']);
        $sitemap = "<urlset>";
        $url     = config('app.url');
        foreach ($notes as $note) {
            $sitemap .= <<<TOR

    <url>
        <loc>{$url}/note/{$note['id']}.html</loc>
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
