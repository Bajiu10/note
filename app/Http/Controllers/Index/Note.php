<?php

namespace App\Http\Controllers\Index;

use App\Dao\CategoryDao;
use App\Dao\CommentDao;
use App\Dao\NoteDao;
use App\Http\Controller;
use App\Http\Traits\Paginate;
use App\Models\Comments;
use App\Models\Notes;
use Max\Di\Annotations\Inject;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;

class Note extends Controller
{
    use Paginate;

    #[Inject]
    protected Notes $notes;

    #[Inject]
    protected Comments $comments;

    #[GetMapping(path: '/note/(\d+)\.html', alias: 'read')]
    public function read($id, NoteDao $noteDao, CommentDao $commentDao)
    {
        if (!empty($note = $noteDao->findOne($id))) {
            $noteDao->incrHits($id, $note['hits']);
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

    #[
        RequestMapping(path: 'notes/add'),
        Middleware(\App\Http\Middleware\Common\Login::class)
    ]
    public function create(CategoryDao $categoryDao, NoteDao $noteDao)
    {
        if ($this->request->isMethod('get')) {
            return view(config('app.theme') . '/notes/add', ['categories' => $categoryDao->all()]);
        }
        try {
            $insertedId = $noteDao->createOne(Session::get('user.id'), $this->request->post(
                ['title', 'text', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => ''])
            );
        } catch (\Exception $e) {
            throw new \Exception('新增失败了: ' . $e->getMessage());
        }
        return redirect(url('read', [$insertedId]));
    }

    #[
        RequestMapping(path: 'notes/edit/(\d+)', alias: 'edit'),
        Middleware(\App\Http\Middleware\Common\Login::class)
    ]
    public function edit($id, NoteDao $noteDao, CategoryDao $categoryDao)
    {
        $note = $noteDao->findOne($id, Session::get('user.id'));

        if ($this->request->isMethod('get')) {
            $categories = $categoryDao->all();
            return view(config('app.theme') . '/notes/edit', compact(['note', 'categories']));
        }
        $note = $this->request->post(['title', 'text', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => '']);
        try {
            $noteDao->updateOne($id, $note);
            return redirect(url('read', [$id]));
        } catch (\Exception $exception) {
            throw new \Exception('更新失败了！');
        }
    }

    #[
        RequestMapping(path: 'notes/delete/(\d+)'),
        Middleware(\App\Http\Middleware\Common\Login::class)
    ]
    public function delete($id, NoteDao $noteDao)
    {
        if ($noteDao->deleteOne($id, Session::get('user.id'))) {
            return redirect('/');
        }
        throw new \Exception('删除失败了！');
    }
}
