<?php

namespace App\Http\Controllers\Api;

use App\Dao\CommentDao;
use App\Dao\HeartDao;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CommentRequest;
use App\Services\TencentCloud\Captcha;
use Max\Foundation\Facades\DB;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\PostMapping;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Comment
 *
 * @package App\Http\Controllers\Api
 */
#[\Max\Routing\Annotations\Controller(prefix: 'api/notes', middlewares: ['api'])]
class Comment extends ApiController
{
    /**
     * @param            $noteId
     * @param CommentDao $commentDao
     * @param HeartDao   $heartDao
     *
     * @return array
     */
    #[GetMapping(path: '/<id>/comments')]
    public function index($noteId, CommentDao $commentDao, HeartDao $heartDao): array
    {
        $page         = (int)$this->request->get('page', 1);
        $order        = $this->request->get('order', 0);
        $commentCount = $commentDao->amountOfOneNote($noteId);
        $comments     = $commentDao->read($noteId, $page, $order);
        $hearts       = $heartDao->getIdsByIp($this->request->ip())->toArray();
        foreach ($comments['top'] as &$value) {
            $value['hearted'] = in_array($value['id'], $hearts);
        }
        return $this->success([
            'total' => $commentCount,
            'data'  => $comments,
        ]);
    }

    /**
     * @param CommentRequest $request
     * @param CommentDao     $commentDao
     * @param Captcha        $captcha
     *
     * @return array
     */
    #[PostMapping(path: '/comment')]
    public function store(ServerRequestInterface $request, CommentDao $commentDao, Captcha $captcha): array
    {
        $data      = $request->post(['comment', 'note_id', 'name', 'ticket', 'randstr'], ['name' => '匿名用户']);
        $validator = \Max\Foundation\Facades\Validator::make($data, [
            'comment' => 'required|max:255',
            'ticket'  => 'required',
            'randstr' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        if ($captcha->valid($data['ticket'], $data['randstr'])) {
            unset($data['ticket'], $data['randstr']);
            $id = $commentDao->createOne($data);
            return $this->success([
                'id' => $id,
            ]);
        }

        return $this->error('验证失败');
    }

    /**
     * @param          $id
     * @param HeartDao $heartDao
     *
     * @return array
     */
    #[GetMapping(path: '/heart/<id>')]
    public function heart($id, HeartDao $heartDao): array
    {
        if (!DB::table('comments')->where('id', $id)->exists()) {
            return $this->error('评论不存在');
        }
        $userId = $this->request->ip();
        if ($heartDao->hasOneByCommentId($id, $userId)) {
            $heartDao->deleteOneByCommentId($id, $userId);
            return $this->success([], '取消喜欢', 0);
        }
        $heartDao->createOne(['comment_id' => $id, 'user_id' => $userId]);

        return $this->success([], '喜欢', 1);
    }
}
