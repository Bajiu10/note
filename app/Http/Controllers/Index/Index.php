<?php

namespace App\Http\Controllers\Index;

use App\Dao\CommentDao;
use App\Dao\LinkDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Traits\Paginate;
use Max\Cache\Cache;
use Max\Di\Annotations\Inject;
use Max\Redis\Redis;
use Max\Routing\Annotations\GetMapping;

/**
 * Class Index
 *
 * @package App\Http\Controllers\Index
 */
#[\Max\Routing\Annotations\Controller(prefix: '/')]
class Index extends Controller
{
    use Paginate;

    /**
     * @var NoteDao
     */
    #[Inject]
    protected NoteDao $noteDao;

    /**
     * @param LinkDao    $linkDao
     * @param CommentDao $commentDao
     *
     * @return mixed
     * @throws \Exception
     */
    #[
        GetMapping(path: '/'),
    ]
    public function index(LinkDao $linkDao, CommentDao $commentDao)
    {
        $page     = (int)$this->request->get('p', 1);
        $paginate = $this->paginate($page, ceil($this->noteDao->getAmount() / 8), 8);
        $hots     = $this->noteDao->recommend(10);
        $notes    = $this->noteDao->getSome($page);
        $links    = $linkDao->all();
        $comments = $commentDao->getSome();
        return view(config('app.theme') . '/index', compact(['notes', 'paginate', 'links', 'hots', 'comments']));
    }

    /**
     * @param Cache $cache
     *
     * @return mixed
     */
    #[GetMapping(path: '/about')]
    public function about(Cache $cache)
    {
        $stat = $cache->get('stat');
        return view(config('app.theme') . '/about', compact(['stat']));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    #[GetMapping(path: '/search')]
    public function search()
    {
        $page = (int)$this->request->get('p', 1);
        if (empty($keyword = $this->request->get('kw'))) {
            throw new \Exception('关键词不存在！😂😂😂');
        }
        $totalPage = ceil($this->noteDao->countSearch($keyword) / 8);
        $notes     = $this->noteDao->search($keyword, offset: ($page - 1) * 8);
        $paginate  = $this->paginate($page, $totalPage, 8);

        return view(config('app.theme') . '/notes/search', compact(['notes', 'keyword', 'paginate', 'totalPage']));
    }

    /**
     * @param Redis $redis
     *
     * @return mixed
     * @throws \Exception
     * @deprecated
     */
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
