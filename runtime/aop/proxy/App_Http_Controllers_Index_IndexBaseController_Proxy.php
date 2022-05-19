<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\BaseController;
use App\Model\Dao\CommentDao;
use App\Model\Dao\NoteDao;
use App\Model\Entities\Link;
use App\Services\Paginate;
use Exception;
use Max\Aop\Annotation\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Http\Annotations\Controller;
use Max\Http\Annotations\GetMapping;
use Max\Http\Exceptions\HttpException;
use Max\Redis\Manager;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Throwable;
use function view;
#[Controller(prefix: '/')]
class IndexBaseController extends BaseController
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct()
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct(...func_get_args());
        }
        $this->__handleProperties();
    }
    use Paginate;
    /**
     * @var \App\Model\Dao\NoteDao
     */
    #[Inject]
    protected NoteDao $noteDao;
    #[Inject]
    protected Manager $redis;
    #[Inject]
    protected CommentDao $commentDao;
    /**
     * @return ResponseInterface
     * @throws NotFoundException
     * @throws ReflectionException
     * @throws Throwable
     * @throws \Swoole\Exception
     */
    #[GetMapping(path: '/')]
    public function index() : ResponseInterface
    {
        $page = (int) $this->request->get('p', 1);
        $paginate = $this->paginate($page, ceil($this->noteDao->getAmount() / 8), 8);
        $hots = $this->noteDao->recommend(10);
        $notes = $this->noteDao->getSome($page);
        $links = Link::all()->toArray();
        $comments = $this->commentDao->getSome();
        return view('index', compact(['notes', 'paginate', 'links', 'hots', 'comments']));
    }
    /**
     * @return ResponseInterface
     * @throws Throwable
     * @throws NotFoundException
     * @throws ReflectionException
     */
    #[GetMapping(path: '/about')]
    public function about() : ResponseInterface
    {
        $stat = (float) $this->redis->get('stat');
        return view('about', compact(['stat']));
    }
    /**
     * @return ResponseInterface
     * @throws HttpException
     * @throws Throwable
     */
    #[GetMapping(path: '/search')]
    public function search() : ResponseInterface
    {
        $page = (int) $this->request->get('p', 1);
        if (empty($keyword = $this->request->get('kw'))) {
            throw new Exception('关键词不存在！😂😂😂');
        }
        $totalPage = ceil($this->noteDao->countSearch($keyword) / 8);
        $notes = $this->noteDao->search($keyword, offset: ($page - 1) * 8);
        $paginate = $this->paginate($page, $totalPage, 8);
        return view('notes.search', compact(['notes', 'keyword', 'paginate', 'totalPage']));
    }
}