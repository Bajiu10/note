<?php

namespace App\Http\Controllers\Index;

use App\Dao\CategoryDao;
use App\Dao\CommentDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Middleware\Common\Login;
use App\Http\Traits\Paginate;
use App\Models\Comments;
use App\Models\Notes;
use Max\Di\Annotations\Inject;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;

/**
 * Class Note
 * @package App\Http\Controllers\Index
 */
class Note extends Controller
{
    use Paginate;

    /**
     * @var Notes
     */
    #[Inject]
    protected Notes $notes;

    /**
     * @var NoteDao
     */
    #[Inject]
    protected NoteDao $noteDao;

    /**
     * @var Comments
     */
    #[Inject]
    protected Comments $comments;

    /**
     * @param $id
     * @param CommentDao $commentDao
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
            $this->noteDao->incrHits($id, $note['hits']);
            $order = $this->request->get('order', 0);
            $comments_count = $commentDao->amountOfOneNote($id);
            $comments = $this->comments->read($id, 1, $order);
            $sub_comments = $comments['sub'];
            $hots = $this->notes->hots();
            $recommended = $this->notes->getRecommended($note['cid'], $id);
            if (!empty($note->tags)) {
                $note->tags = explode(',', $note->tags);
            }
            return view(config('app.theme') . '/notes/read', compact(['note', 'comments_count', 'comments', 'hots', 'recommended', 'sub_comments']));
        }
        throw new \Exception('笔记不存在！', 404);
    }

    /**
     * @param CategoryDao $categoryDao
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
            $insertedId = $this->noteDao->createOne(Session::get('user.id'), $this->request->post(
                ['title', 'text', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => ''])
            );
        } catch (\Exception $e) {
            throw new \Exception('新增失败了: ' . $e->getMessage());
        }
        return redirect(url('read', [$insertedId]));
    }

    /**
     * @param $id
     * @param CategoryDao $categoryDao
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
        $note = $this->request->post(['title', 'text', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => '']);
        try {
            $this->noteDao->updateOne($id, $note);
            return redirect(url('read', [$id]));
        } catch (\Exception $exception) {
            throw new \Exception('更新失败了！');
        }
    }

    /**
     * @param $id
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
