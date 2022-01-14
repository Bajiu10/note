<?php

namespace App\Http\Controllers\Index;

use App\Dao\CommentDao;
use App\Dao\LinkDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Traits\Paginate;
use Exception;
use Max\Cache\Cache;
use Max\Di\Annotations\Inject;
use Max\Routing\Annotations\GetMapping;

/**
 * Class Index
 *
 * @package App\Http\Controllers\Index
 */
#[\Max\Routing\Annotations\Controller(prefix: '/', middleware: ['web'])]
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
     * @return false|string
     * @throws Exception
     */
    #[GetMapping(path: '/')]
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
     * @return false|string
     */
    #[GetMapping(path: '/about')]
    public function about(Cache $cache)
    {
        $stat = $cache->get('stat');
        return view(config('app.theme') . '/about', compact(['stat']));
    }

    /**
     * @return false|string
     * @throws Exception
     */
    #[GetMapping(path: '/search')]
    public function search(): bool|string
    {
        $page = (int)$this->request->get('p', 1);
        if (empty($keyword = $this->request->get('kw'))) {
            throw new Exception('关键词不存在！😂😂😂');
        }
        $totalPage = ceil($this->noteDao->countSearch($keyword) / 8);
        $notes     = $this->noteDao->search($keyword, offset: ($page - 1) * 8);
        $paginate  = $this->paginate($page, $totalPage, 8);

        return view(config('app.theme') . '/notes/search', compact(['notes', 'keyword', 'paginate', 'totalPage']));
    }
}
