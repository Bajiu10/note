<?php

namespace App\Console\Commands;

use Exception;
use Max\Console\Commands\Command;
use Max\Database\Query;
use Max\Di\Annotations\Inject;
use Throwable;

class Sitemap extends Command
{
    #[Inject]
    protected Query $query;

    /**
     * @var string
     */
    protected string $name = 'baidu:sitemap';
    /**
     * @var string
     */
    protected string $description = '生成sitemap';

    /**
     * @throws Exception|Throwable
     */
    public function run()
    {
        $notes   = $this->query->table('notes')->get(['create_time', 'id']);
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
            $this->output->info('Sitemap生成成功，共' . $notes->count() . '条！');
        }
    }

}
