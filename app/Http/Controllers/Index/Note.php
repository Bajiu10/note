<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Http\Traits\Paginate;
use App\Models\Comments;
use App\Models\Notes;
use Max\Di\Annotations\Inject;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\DB;
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
    public function read($id)
    {
        $note = DB::table('notes')
                  ->leftJoin('categories')->on('categories.id', '=', 'notes.cid')
                  ->where('notes.id', '=', $id)
                  ->whereNull('notes.delete_time')
                  ->first([
                      'title',
                      'notes.id',
                      'categories.name category',
                      'UNIX_TIMESTAMP(`update_time`) update_time',
                      'text',
                      'hits',
                      'tags',
                      'thumb',
                      'abstract',
                      'UNIX_TIMESTAMP(`create_time`) create_time',
                      'user_id',
                      'cid']);
        if (!empty($note)) {
            DB::table('notes')->where('id', '=', $id)
              ->update(['hits' => $note['hits'] + 1]);
            $order          = $this->request->get('order', 0);
            $comments_count = DB::table('comments')->where('note_id', '=', $id)->count($id);
            $comments       = $this->comments->read($id, 1, $order);
            $sub_comments   = $comments['sub'];
            $hots           = $this->notes->hots();
            $recommended    = $this->notes->getRecommended($note['cid'], $id);
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
    public function create()
    {
        if ($this->request->isMethod('get')) {
            $categories = DB::table('categories')->order('id')->get();
            return view(config('app.theme') . '/notes/add', compact(['categories']));
        }
        $data = $this->request->post(['title', 'text', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => '']);
        if (empty($data['abstract'])) {
            $data['abstract'] = substr($data['text'], 0, 300);
        }
        $data['user_id'] = Session::get('user.id');
        try {
            $insertedId = DB::table('notes')->insert($data);
        } catch (\Exception $e) {
            throw new \Exception('新增失败了: ' . $e->getMessage());
        }
        return redirect(url('read', [$insertedId]));
    }

    #[
        RequestMapping(path: 'notes/edit/(\d+)', alias: 'edit'),
        Middleware(\App\Http\Middleware\Common\Login::class)
    ]
    public function edit($id = 0)
    {
        $note = DB::table('notes')
                  ->leftJoin('categories')->on('categories.id', '=', 'notes.cid')
                  ->where('notes.id', '=', $id)
                  ->whereNull('notes.delete_time')
                  ->first([
                      'title',
                      'notes.id',
                      'categories.name category',
                      'UNIX_TIMESTAMP(`update_time`) update_time',
                      'text',
                      'hits',
                      'tags',
                      'thumb',
                      'abstract',
                      'UNIX_TIMESTAMP(`create_time`) create_time',
                      'user_id',
                      'cid'
                  ]);
        if (!empty($note)) {
            DB::table('notes')->where('id', '=', $id)->update(['hits' => $note['hits'] + 1]);
        }
        if ($note['user_id'] !== Session::get('user.id')) {
            throw new \Exception('你没有权限！');
        }

        if ($this->request->isMethod('get')) {
            $categories = DB::table('categories')->get();
            return view(config('app.theme') . '/notes/edit', compact(['note', 'categories']));
        }
        $note                = $this->request->post(['title', 'text', 'tags', 'abstract', 'cid', 'thumb'], ['tags' => '']);
        $note['update_time'] = date('Y-m-d H:i:s');
        try {
            DB::table('notes')->where('id', '=', $id)->update($note);
            return redirect(url('read', [$id]));
        } catch (\Exception $e) {
            throw new \Exception('更新失败了！');
        }
    }

    #[
        RequestMapping(path: 'notes/delete/(\d+)'),
        Middleware(\App\Http\Middleware\Common\Login::class)
    ]
    public function delete($id)
    {
        if (DB::table('notes')
              ->where('id', '=', $id)
              ->where('user_id', '=', Session::get('user.id'))
              ->update(['delete_time' => date('Y-m-d H:i:s')])) {
            return redirect('/');
        }
        throw new \Exception('删除失败了！');
    }
}
