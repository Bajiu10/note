<?php

namespace App\Http\Controllers\Api;

use App\Dao\CommentDao;
use App\Dao\HeartDao;
use App\Http\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use Max\Foundation\Facades\DB;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\PostMapping;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Comment
 *
 * @package App\Http\Controllers\Api
 */
#[\Max\Routing\Annotations\Controller(prefix: 'api/notes', middleware: ['api'])]
class Comment extends Controller
{
    /**
     * @param CommentRequest $request
     * @param CommentDao     $commentDao
     *
     * @return array
     */
    #[PostMapping(path: '/comment')]
    public function create(ServerRequestInterface $request, CommentDao $commentDao)
    {
        try {
            $id = $commentDao->createOne($request->post(['comment', 'note_id', 'name'], ['name' => '匿名用户']));

            return ['status' => 1, 'message' => 'Success', 'id' => $id];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }

    /**
     * @param          $id
     * @param HeartDao $heartDao
     *
     * @return array
     */
    #[GetMapping(path: '/heart/(\d+)')]
    public function heart($id, HeartDao $heartDao)
    {
        if (!DB::table('comments')->where('id', $id)->exists()) {
            return ['status' => -1, 'message' => '评论不存在'];
        }
        $userId = $this->request->ip();
        if ($heartDao->hasOneByCommentId($id, $userId)) {
            $heartDao->deleteOneByCommentId($id, $userId);
            return ['status' => 0, 'message' => '取消喜欢成功!'];
        }
        $heartDao->createOne(['comment_id' => $id, 'user_id' => $userId]);
        return ['status' => 1, 'message' => '喜欢成功!'];
    }
}
