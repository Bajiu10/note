<?php

namespace App\Http\Controllers\Api;

use App\Dao\UserDao;
use App\Http\Controllers\ApiController;
use App\Http\Middlewares\SessionMiddleware;
use App\Services\TencentCloud\Captcha;
use Max\Di\Annotations\Inject;
use Max\Routing\Annotations\Controller;
use Max\Routing\Annotations\PostMapping;
use Max\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Swoole\Exception;
use Throwable;

#[Controller(prefix: 'api/auth', middlewares: [SessionMiddleware::class])]
class Auth extends ApiController
{
    #[Inject]
    protected Session $session;

    #[Inject]
    protected Captcha $captcha;

    /**
     * @throws Throwable
     * @throws Exception
     */
    #[PostMapping(path: '/login')]
    public function login(UserDao $userDao): ResponseInterface
    {
        $data = $this->request->post(['username', 'password', 'ticket', 'randstr']);
        if ($this->captcha->valid($data['ticket'], $data['randstr'])) {
            unset($data['ticket'], $data['randstr']);
            if ($user = $userDao->findOneByCredentials($data)) {
                $this->session->set('user', $user);
                return $this->success([], '登录成功');
            }
            return $this->error('用户名或者密码错误');
        }

        return $this->error('验证失败');
    }
}
