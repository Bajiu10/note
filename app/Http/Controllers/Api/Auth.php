<?php

namespace App\Http\Controllers\Api;

use App\Dao\UserDao;
use App\Http\Controllers\ApiController;
use App\Lib\Jwt;
use App\Model\Entities\User;
use App\Services\TencentCloud\Captcha;
use Max\Di\Annotations\Inject;
use Max\Foundation\Session;
use Max\Routing\Annotations\Controller;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\PostMapping;
use Max\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Swoole\Exception;
use Throwable;

#[Controller(prefix: 'api/auth')]
class Auth extends ApiController
{
    #[Inject]
    protected Session $session;

    #[Inject]
    protected Captcha $captcha;

    #[Inject]
    protected Jwt $jwt;

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

    #[PostMapping(path: '/reg')]
    public function register()
    {
        $validator = (new Validator())->make($this->request->all(), [
            'username' => 'required',
            'email'    => 'email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $user = User::create($this->request->all());
        $this->session->set('user', $user->toArray());
        return $this->success([]);
    }

    #[GetMapping(path: '/token')]
    public function token(): ResponseInterface
    {
        if ($user = $this->session->get('user')) {
            return $this->success([
                'token' => $this->jwt->encode(['id' => $user['id']]),
                'user'  => $user,
            ]);
        }
        return $this->error('认证失败');
    }
}
