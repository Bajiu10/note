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
use Max\Foundation\Exceptions\HttpException;
use Max\Routing\Annotations\GetMapping;
use Psr\Http\Message\ResponseInterface;
use Throwable;

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
     * @return ResponseInterface
     * @throws HttpException
     * @throws Throwable
     */
    #[GetMapping(path: '/')]
    public function index(LinkDao $linkDao, CommentDao $commentDao):ResponseInterface
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
     * @return ResponseInterface
     * @throws HttpException
     * @throws Throwable
     */
    #[GetMapping(path: '/about')]
    public function about(Cache $cache): ResponseInterface
    {
        $stat = $cache->get('stat');
        return view(config('app.theme') . '/about', compact(['stat']));
    }

    /**
     * @return ResponseInterface
     * @throws HttpException
     * @throws Throwable
     */
    #[GetMapping(path: '/search')]
    public function search(): ResponseInterface
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
