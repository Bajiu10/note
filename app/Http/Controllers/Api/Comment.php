<?php

namespace App\Http\Controllers\Api;

use App\Http\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use Max\Foundation\Facades\DB;

class Comment extends Controller
{
    public function create(CommentRequest $request)
    {
        try {
            $comment = $request->post(['comment', 'note_id', 'name'], ['name' => '匿名用户']);
            $id      = DB::table('comments')->insert($comment);
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e->getMessage()];
        }
        return ['status' => 1, 'message' => 'Success', 'id' => $id];
    }

    public function heart($id)
    {
        if (!DB::table('comments')->where('id', '=', $id)->exists()) {
            return ['status' => -1, 'message' => '评论不存在'];
        }
        $userId = $this->request->ip();
        if (DB::table('hearts')
              ->where('comment_id', '=', $id)
              ->where('user_id', '=', $userId)->exists()
        ) {
            DB::table('hearts')
              ->where('comment_id', '=', $id)
              ->where('user_id', '=', $userId)->delete();
            return ['status' => 0, 'message' => '取消喜欢成功!'];
        }
        DB::table('hearts')->insert(['comment_id' => $id, 'user_id' => $userId]);
        return ['status' => 1, 'message' => '喜欢成功!'];
    }

    public function page($note_id, $page, Comments $comments)
    {
        $order = $this->request->get('order', 0);
        return $comments->read($note_id, $page, $order);
    }
}
