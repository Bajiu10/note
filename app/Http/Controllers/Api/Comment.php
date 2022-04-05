<?php

namespace App\Http\Controllers\Api;

use App\Dao\CommentDao;
use App\Dao\HeartDao;
use App\Http\Controllers\ApiController;
use App\Services\TencentCloud\Captcha;
use Max\Database\Query;
use Max\Di\Annotations\Inject;
use Max\Http\Exceptions\HttpException;
use Max\Foundation\Http\Annotations\Controller;
use Max\Foundation\Http\Annotations\GetMapping;
use Max\Foundation\Http\Annotations\PostMapping;
use Max\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Swoole\Exception;
use Throwable;

/**
 * Class Comment
 *
 * @package App\Http\Controllers\Api
 */
#[Controller(prefix: 'api/notes')]
class Comment extends ApiController
{
    #[Inject]
    protected Validator $validator;

    /**
     * @param            $id
     * @param CommentDao $commentDao
     *
     * @return ResponseInterface
     */
    #[GetMapping(path: '/<id>/comments')]
    public function index($id, CommentDao $commentDao): ResponseInterface
    {
        return $this->success([
            'total' => $commentDao->amountOfOneNote($id),
            'data'  => $commentDao->read($this->request, $id),
        ]);
    }

    /**
     * @param CommentDao $commentDao
     * @param Captcha    $captcha
     *
     * @return ResponseInterface
     * @throws HttpException
     */
    #[PostMapping(path: '/comment')]
    public function store(CommentDao $commentDao, Captcha $captcha): ResponseInterface
    {
        $data      = $this->request->post(['comment', 'email', 'note_id', 'name', 'ticket', 'randstr'], ['name' => '匿名用户']);
        $validator = $this->validator->make($data, [
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
     * @param Query    $query
     *
     * @return ResponseInterface
     * @throws Exception
     * @throws Throwable
     */
    #[GetMapping(path: '/heart/<id>')]
    public function heart($id, HeartDao $heartDao, Query $query): ResponseInterface
    {
        if (!$query->table('comments')->where('id', $id)->exists()) {
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
