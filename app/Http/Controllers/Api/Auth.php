<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Lib\Jwt;
use App\Model\Entities\User;
use App\Services\TencentCloud\Captcha;
use Max\Di\Annotations\Inject;
use Max\Foundation\Http\Session;
use Max\Http\Exceptions\HttpException;
use Max\Foundation\Http\Annotations\Controller;
use Max\Foundation\Http\Annotations\GetMapping;
use Max\Foundation\Http\Annotations\PostMapping;
use Max\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
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
     */
    #[PostMapping(path: '/login')]
    public function login(): ResponseInterface
    {
        $data = $this->request->post(['email', 'password', 'ticket', 'randstr']);
        if ($this->captcha->valid($data['ticket'], $data['randstr'])) {
            unset($data['ticket'], $data['randstr']);
            if ($user = User::where('email', $data['email'])->where('password', md5($data['password']))->first()) {
                $this->session->set('user', $user->toArray());
                return $this->success([], '登录成功');
            }
            return $this->error('用户名或者密码错误');
        }

        return $this->error('验证失败');
    }

    /**
     * @throws Throwable
     * @throws HttpException
     */
    #[PostMapping(path: '/reg')]
    public function register(): ResponseInterface
    {
        $data = $this->request->all();
        $validator = (new Validator())->make($data, [
            'username' => 'required',
            'email' => 'email|required',
            'password' => 'required',
            'avatar' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        if ($this->captcha->valid($data['ticket'], $data['randstr'])) {
            $data['password'] = md5($data['password']);
            try {
                $user = User::create($data);
                $this->session->set('user', $user->toArray());
                return $this->success([]);
            } catch (Throwable) {
                return $this->error('邮箱已经被使用');
            }
        }
        return $this->error('验证失败');
    }

    #[GetMapping(path: '/token')]
    public function token(): ResponseInterface
    {
        if ($user = $this->session->get('user')) {
            return $this->success([
                'token' => $this->jwt->encode(['id' => $user['id']]),
                'user' => $user,
            ]);
        }
        return $this->error('认证失败');
    }
}
