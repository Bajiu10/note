<?php

namespace App\Http\Controllers\Index;

use App\Dao\CategoryDao;
use App\Dao\CommentDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Middlewares\Login;
use App\Http\Middlewares\SessionMiddleware;
use App\Http\Traits\Paginate;
use Exception;
use Max\Di\Annotations\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Server\Http\Annotations\Middleware;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;
use Max\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Throwable;

/**
 * Class Note
 *
 * @package App\Http\Controllers\Index
 */
#[\Max\Routing\Annotations\Controller(prefix: '/', middlewares: [SessionMiddleware::class])]
class Note extends Controller
{
    use Paginate;

    #[Inject]
    protected Session $session;

    #[Inject]
    protected NoteDao $noteDao;

    #[Inject]
    protected LoggerInterface $logger;

    /**
     * @param            $id
     * @param CommentDao $commentDao
     *
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[GetMapping(path: '/note/<id>.html', name: 'read')]
    public function show($id, CommentDao $commentDao): ResponseInterface
    {
        if (!empty($note = $this->noteDao->findOne($id))) {
            $this->noteDao->incrHits($id, $note['hits']);
            if (1 == $note['permission'] && $this->session->get('user.id') != $note['user_id']) {
                throw new Exception('你没有权限查看~');
            }
            $note['tags']  = empty($note['tags']) ? [] : explode(',', $note['tags']);
            $commentsCount = $commentDao->amountOfOneNote($id);
            $hots          = $this->noteDao->hots();
            $recommended   = $this->noteDao->getRecommended($note['cid'], $id);
            if (!empty($note->tags)) {
                $note->tags = explode(',', $note->tags);
            }
            return view(config('app.theme') . '/notes/read', compact(['note', 'commentsCount', 'hots', 'recommended']));
        }
        throw new Exception('笔记不存在！', 404);
    }

    /**
     * @param CategoryDao $categoryDao
     *
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[
        RequestMapping(path: 'notes/add'),
        Middleware(Login::class)
    ]
    public function create(CategoryDao $categoryDao): ResponseInterface
    {
        if ($this->request->isMethod('get')) {
            return view(config('app.theme') . '/notes/add', ['categories' => $categoryDao->all()]);
        }
        try {
            $insertedId = $this->noteDao->createOne(
                $this->session->get('user.id'),
                $this->request->post(['title', 'text', 'tags', 'sort', 'abstract', 'cid', 'thumb', 'permission'], ['tags' => ''])
            );
        } catch (Exception $e) {
            throw new Exception('新增失败了: ' . $e->getMessage());
        }
        return redirect('/note/' . $insertedId . '.html');
    }

    /**
     * @param             $id
     * @param CategoryDao $categoryDao
     *
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[
        RequestMapping(path: 'notes/edit/<id>', name: 'edit'),
        Middleware(Login::class)
    ]
    public function edit($id, CategoryDao $categoryDao): ResponseInterface
    {
        $note = $this->noteDao->findOne($id, $this->session->get('user.id'));

        if ($this->request->isMethod('get')) {
            $categories = $categoryDao->all();
            return view(config('app.theme') . '/notes/edit', compact(['note', 'categories']));
        }
        try {
            $this->noteDao->updateOne($id, $this->request->post(
                ['title', 'sort', 'text', 'permission', 'tags', 'abstract', 'cid', 'thumb'],
                ['tags' => '', 'sort' => 0]
            ));
            return redirect('/note/' . $id . '.html');
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());
            throw new Exception('更新失败了！');
        }
    }


    /**
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws Exception
     */
    #[
        RequestMapping(path: 'notes/delete/<id>'),
        Middleware(Login::class)
    ]
    public function destroy($id): ResponseInterface
    {
        if ($this->noteDao->deleteOne($id, $this->session->get('user.id'))) {
            return redirect('/');
        }
        throw new Exception('删除失败了！');
    }
}
