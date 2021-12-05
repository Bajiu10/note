<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Http\Traits\Paginate;
use App\Models\Notes;
use Max\Cache\Cache;
use Max\Foundation\Facades\DB;
use Max\Redis\Redis;
use Max\Routing\Annotations\GetMapping;

#[\Max\Routing\Annotations\Controller(prefix: '/', middleware: ['web'])]
class Index extends Controller
{
    use Paginate;

    protected const NUMBER_OF_PAGES = 8;

    #[GetMapping(path: '/')]
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

    #[GetMapping(path: '/about')]
    public function about(Cache $cache)
    {
        $stat = $cache->get('stat');
        return view(config('app.theme') . '/about', compact(['stat']));
    }

    #[GetMapping(path: '/search')]
    public function search(Notes $notes)
    {
        $keyword = $this->request->get('kw');
        $page    = (int)$this->request->get('p', 1);
        if (empty($keyword)) {
            throw new \Exception('关键词不存在！😂😂😂');
        }
        $count     = $notes->searchCount($keyword);
        $totalPage = ceil($count / self::NUMBER_OF_PAGES);
        $notes     = $notes->search($keyword, self::NUMBER_OF_PAGES, ($page - 1) * 8);
        $notes     = collect($notes)->map(function($value) {
            $value['thumb'] = $value['thumb'] ?: '/static/bg/bg' . rand(1, 18) . '.jpg';
            return $value;
        });
        $paginate  = $this->paginate($page, $totalPage, self::NUMBER_OF_PAGES);

        return view(config('app.theme') . '/notes/search', compact(['notes', 'keyword', 'paginate', 'totalPage']));
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
