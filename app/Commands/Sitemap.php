<?php

namespace App\Commands;

use Max\Console\Commands\Command;
use Max\Console\Contracts\InputInterface;
use Max\Console\Contracts\OutputInterface;
use Max\Database\Query;
use Max\Di\Annotations\Inject;

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
     * @throws \Exception
     */
    public function run(InputInterface $input, OutputInterface $output): int
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
            return $output->info('Sitemap生成成功，共' . $notes->count() . '条！');
        }
    }

}
