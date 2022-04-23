<?php

namespace App\Controllers\Index;

use App\Controllers\Controller;
use App\Middlewares\Authentication;
use App\Model\Dao\NoteDao;
use App\Model\Entities\Category;
use App\Model\Entities\Comment;
use App\Model\Entities\Note;
use App\Services\Paginate;
use Exception;
use Max\Database\Query\Expression;
use Max\Di\Annotation\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Http\Annotations\GetMapping;
use Max\Http\Annotations\RequestMapping;
use Max\Http\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Throwable;
use function redirect;
use function view;

/**
 * Class Note
 *
 * @package App\Http\Controllers\Index
 */
#[\Max\Http\Annotations\Controller(prefix: '/')]
class NoteController extends Controller
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
     *
     * @return ResponseInterface
     * @throws Throwable
     * @throws \Swoole\Exception
     */
    #[GetMapping(path: '/note/<id>.html')]
    public function show($id): ResponseInterface
    {
        if (!empty($note = $this->noteDao->findOne($id))) {
            Note::where('id', $id)->update([
                'hits' => new Expression('hits + 1')
            ]);
            if (Note::PERMISSION_LOGIN == $note['permission'] && !$this->session->get('user.id')) {
                throw new Exception('登录后可查看~');
            }
            $commentsCount = Comment::where('note_id', $id)->count();
            $hots          = $this->noteDao->hots();
            $recommended   = $this->noteDao->getRecommended($note['cid'], $id);
            if (!empty($note->tags)) {
                $note->tags = explode(',', $note->tags);
            }
            return view('notes.read', compact(['note', 'commentsCount', 'hots', 'recommended']));
        }
        throw new Exception('笔记不存在！', 404);
    }

    /**
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[RequestMapping(path: 'notes/add', middlewares: [Authentication::class])]
    public function create(): ResponseInterface
    {
        if ($this->request->isMethod('get')) {
            return view('notes.add', ['categories' => Category::all()->toArray()]);
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
     *
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[RequestMapping(path: 'notes/edit/<id>', middlewares: [Authentication::class])]
    public function edit($id): ResponseInterface
    {
        if ($note = $this->noteDao->findOne($id, $this->session->get('user.id'))) {
            if ($this->request->isMethod('get')) {
                $categories = Category::all()->toArray();
                return view('notes.edit', compact(['note', 'categories']));
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
        throw new Exception('笔记不存在');
    }


    /**
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws Exception
     */
    #[RequestMapping(path: 'notes/delete/<id>', middlewares: [Authentication::class])]
    public function destroy($id): ResponseInterface
    {
        if ($this->noteDao->deleteOne($id, $this->session->get('user.id'))) {
            return redirect('/');
        }
        throw new Exception('删除失败了！');
    }
}
