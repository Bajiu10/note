<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Middlewares\TencentCaptchaMiddleware;
use App\Model\Dao\CommentDao;
use App\Model\Dao\HeartDao;
use Max\Aop\Annotation\Inject;
use Max\Database\Manager;
use Max\Di\Exceptions\NotFoundException;
use Max\Http\Annotations\Controller;
use Max\Http\Annotations\GetMapping;
use Max\Http\Annotations\PostMapping;
use Max\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Swoole\Exception;
use Throwable;
/**
 * Class Comment
 *
 * @package App\Http\Controllers\Api
 */
#[Controller(prefix: 'api/notes')]
class CommentController extends ApiController
{
    use \Max\Aop\ProxyHandler;
    use \Max\Aop\PropertyHandler;
    public function __construct()
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct(...func_get_args());
        }
        $this->__handleProperties();
    }
    #[Inject]
    protected Validator $validator;
    /**
     * @param                           $id
     * @param \App\Model\Dao\CommentDao $commentDao
     *
     * @return ResponseInterface
     * @throws Exception
     * @throws Throwable
     */
    #[GetMapping(path: '/<id>/comments')]
    public function index($id, CommentDao $commentDao) : ResponseInterface
    {
        return $this->success(['total' => \App\Model\Entities\Comment::where('note_id', $id)->count(), 'data' => $commentDao->read($this->request, $id)]);
    }
    /**
     * @return ResponseInterface
     * @throws Exception
     * @throws Throwable
     * @throws NotFoundException
     * @throws ReflectionException
     */
    #[PostMapping(path: '/comment', middlewares: [TencentCaptchaMiddleware::class])]
    public function store() : ResponseInterface
    {
        $data = $this->request->post(['comment', 'email', 'note_id', 'name'], ['name' => '匿名用户']);
        $validator = $this->validator->make($data, ['comment' => 'required|max:255']);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $id = \App\Model\Entities\Comment::create($data);
        return $this->success(['id' => $id]);
    }
    /**
     * @param          $id
     * @param HeartDao $heartDao
     * @param Manager  $query
     *
     * @return ResponseInterface
     * @throws Exception
     * @throws Throwable
     */
    #[GetMapping(path: '/heart/<id>')]
    public function heart($id, HeartDao $heartDao, Manager $query) : ResponseInterface
    {
        if (!$query->table('comments')->where('id', $id)->exists()) {
            return $this->error('评论不存在');
        }
        $userId = $this->request->ip();
        if ($heartDao->hasOneByCommentId($id, $userId)) {
            $heartDao->deleteOneByCommentId($id, $userId);
            return $this->success([], '取消喜欢');
        }
        $heartDao->createOne(['comment_id' => $id, 'user_id' => $userId]);
        return $this->success([], '喜欢', 1);
    }
}
