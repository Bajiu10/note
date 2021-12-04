<?php

namespace App\Http\Controllers\Api;

use App\Http\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use App\Models\Hearts;
use Max\Foundation\Facades\DB;

class Comment extends Controller
{
    public function create(CommentRequest $request)
    {
        try {
            $comment = $request->post(['comment', 'note_id', 'name'], ['name' => '匿名用户']);
            $id      = Comments::create($comment);
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e->getMessage()];
        }
        return ['status' => 1, 'message' => 'Success', 'id' => $id];
    }

    public function heart($id, Hearts $hearts, Comments $comments)
    {
        if (!$comments->has(['id' => $id])) {
            return ['status' => -1, 'message' => '评论不存在'];
        }
        $user_id = $this->request->ip();
        if (DB::table('hearts')
              ->where('comment_id', '=', $id,)
              ->where('user_id', '=', $user_id)->exists()
        ) {
            DB::table('hearts')->where('comment_id', '=', $id,)
              ->where('user_id', '=', $user_id)->delete();
            return ['status' => 0, 'message' => '取消喜欢成功!'];
        }
        DB::table('hearts')->insert(['comment_id' => $id, 'user_id' => $user_id]);
        return ['status' => 1, 'message' => '喜欢成功!'];
    }

    public function page($note_id, $page, Comments $comments)
    {
        $order = $this->request->get('order', 0);
        return $comments->read($note_id, $page, $order);
    }
}
