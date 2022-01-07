<?php

namespace App\Http\Controllers\Index;

use App\Dao\CategoryDao;
use App\Dao\CommentDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Middleware\Login;
use App\Http\Traits\Paginate;
use Max\Di\Annotations\Inject;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;

/**
 * Class Note
 *
 * @package App\Http\Controllers\Index
 */
#[\Max\Routing\Annotations\Controller(prefix: '/', middleware: ['web'])]
class Note extends Controller
{
    use Paginate;

    /**
     * @var NoteDao
     */
    #[Inject]
    protected NoteDao $noteDao;

    /**
     * @param            $id
     * @param CommentDao $commentDao
     *
     * @return mixed
     * @throws \Exception
     */
    #[GetMapping(path: '/note/(\d+)\.html', alias: 'read')]
    public function read($id, CommentDao $commentDao)
    {
        if (!empty($note = $this->noteDao->findOne($id))) {
            if (1 == $note['permission'] && Session::get('user.id') != $note['user_id']) {
                throw new \Exception('你没有权限查看~');
            }
            $note['tags'] = empty($note['tags']) ? [] : explode(',', $note['tags']);
            $this->noteDao->incrHits($id, $note['hits']);
            $commentsCount = $commentDao->amountOfOneNote($id);
            $hots          = $this->noteDao->hots();
            $recommended   = $this->noteDao->getRecommended($note['cid'], $id);
            if (!empty($note->tags)) {
                $note->tags = explode(',', $note->tags);
            }
            return view(config('app.theme') . '/notes/read', compact(['note', 'commentsCount', 'hots', 'recommended']));
        }
        throw new \Exception('笔记不存在！', 404);
    }

    /**
     * @param CategoryDao $categoryDao
     *
     * @return mixed
     * @throws \Exception
     */
    #[
        RequestMapping(path: 'notes/add'),
        Middleware(Login::class)
    ]
    public function create(CategoryDao $categoryDao)
    {
        if ($this->request->isMethod('get')) {
            return view(config('app.theme') . '/notes/add', ['categories' => $categoryDao->all()]);
        }
        try {
            $insertedId = $this->noteDao->createOne(
                Session::get('user.id'),
                $this->request->post(['title', 'text', 'tags', 'abstract', 'cid', 'thumb', 'permission'], ['tags' => ''])
            );
        } catch (\Exception $e) {
            throw new \Exception('新增失败了: ' . $e->getMessage());
        }
        return redirect(url('read', [$insertedId]));
    }

    /**
     * @param             $id
     * @param CategoryDao $categoryDao
     *
     * @return mixed
     * @throws \Exception
     */
    #[
        RequestMapping(path: 'notes/edit/(\d+)', alias: 'edit'),
        Middleware(Login::class)
    ]
    public function edit($id, CategoryDao $categoryDao)
    {
        $note = $this->noteDao->findOne($id, Session::get('user.id'));

        if ($this->request->isMethod('get')) {
            $categories = $categoryDao->all();
            return view(config('app.theme') . '/notes/edit', compact(['note', 'categories']));
        }
        try {
            $this->noteDao->updateOne($id, $this->request->post(['title', 'text', 'permission', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => '']));
            return redirect(url('read', [$id]));
        } catch (\Exception $exception) {
            throw new \Exception('更新失败了！');
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Exception
     */
    #[
        RequestMapping(path: 'notes/delete/(\d+)'),
        Middleware(Login::class)
    ]
    public function delete($id)
    {
        if ($this->noteDao->deleteOne($id, Session::get('user.id'))) {
            return redirect('/');
        }
        throw new \Exception('删除失败了！');
    }
}
