<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Http\Traits\Paginate;
use App\Models\Notes;
use Max\Cache\Cache;
use Max\Database\Manager;
use Max\Di\Annotations\Inject;
use Max\Foundation\Facades\DB;
use Max\Redis\Redis;
use Max\Routing\Annotations\GetMapping;

class Index extends Controller
{
    use Paginate;

    #[Inject]
    protected Cache $cache;

    protected const NUMBER_OF_PAGES = 8;

    public function index(Notes $notes)
    {
        $page      = (int)$this->request->get('p', 1);
        $totalPage = ceil(DB::table('notes')->count() / self::NUMBER_OF_PAGES);
        $paginate  = $this->paginate($page, $totalPage, self::NUMBER_OF_PAGES);
        $hots      = $notes->hots(10);
        $notes     = $notes->list($page, self::NUMBER_OF_PAGES)->map(function($value) {
            $value['thumb'] = $value['thumb'] ?: '/static/bg/bg' . rand(1, 18) . '.jpg';
            return $value;
        });
        $links     = DB::table('links')->get();
        $comments  = DB::table('comments')->order('create_time', 'DESC')->limit(5)->get();
        return view(config('app.theme') . '/index', compact(['notes', 'paginate', 'links', 'hots', 'comments']));
    }

    public function about()
    {
        $stat = $this->cache->get('stat');
        return view(config('app.theme') . '/about', compact(['stat']));
    }

    #[GetMapping(path: '/chat/record')]
    public function record(Redis $redis)
    {
        $page     = $this->request->get('p', 1);
        $limit    = 20;
        $start    = $limit * max($page - 1, 0);
        $end      = $limit * $page;
        $data     = array_map(function($value) {
            $value = json_decode($value, true);
            if (str_starts_with($value['data'], 'img:')) {
                $img           = substr($value['data'], 4);
                $value['data'] = "<img style='max-width:100%' src='{$img}'>";
            }
            return $value;
        }, $redis->handle()->lRange('chat', $start, $end));
        $len      = $redis->handle()->lLen('chat');
        $paginate = $this->paginate($page, ceil($len / $limit), $limit);
        return view(config('app.theme') . '/record', ['records' => $data, 'paginate' => $paginate]);
    }
}
