<?php

namespace App\Http\Controllers\Index;

use App\Dao\CommentDao;
use App\Dao\LinkDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Middlewares\SessionMiddleware;
use App\Http\Traits\Paginate;
use Exception;
use Max\Database\Redis;
use Max\Di\Annotations\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Routing\Annotations\GetMapping;
use Max\Server\Exceptions\HttpException;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Throwable;

#[\Max\Routing\Annotations\Controller(prefix: '/', middlewares: [SessionMiddleware::class])]
class Index extends Controller
{
    use Paginate;

    /**
     * @var NoteDao
     */
    #[Inject]
    protected NoteDao $noteDao;

    #[Inject]
    protected Redis $redis;

    /**
     * @param LinkDao    $linkDao
     * @param CommentDao $commentDao
     *
     * @return ResponseInterface
     * @throws HttpException
     * @throws Throwable
     */
    #[GetMapping(path: '/')]
    public function index(LinkDao $linkDao, CommentDao $commentDao): ResponseInterface
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
     * @return ResponseInterface
     * @throws Throwable
     * @throws NotFoundException
     * @throws ReflectionException
     */
    #[GetMapping(path: '/about')]
    public function about(): ResponseInterface
    {
        $stat = (float)$this->redis->get('stat');
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
