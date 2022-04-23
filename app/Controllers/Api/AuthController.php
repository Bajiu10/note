<?php

namespace App\Controllers\Api;

use App\Controllers\ApiController;
use App\Middlewares\TencentCaptchaMiddleware;
use App\Model\Entities\User;
use App\Services\Jwt;
use App\Services\TencentCloud\Captcha;
use Max\Di\Annotation\Inject;
use Max\Http\Annotations\Controller;
use Max\Http\Annotations\GetMapping;
use Max\Http\Annotations\PostMapping;
use Max\Http\Session;
use Max\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Throwable;

#[Controller(prefix: 'api/auth')]
class AuthController extends ApiController
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
    #[PostMapping(path: '/login', middlewares: [TencentCaptchaMiddleware::class])]
    public function login(): ResponseInterface
    {
        $data = $this->request->post(['email', 'password']);
        if ($user = User::where('email', $data['email'])
                        ->where('password', md5($data['password']))
                        ->first()
        ) {
            $this->session->set('user', $user->toArray());
            return $this->success([], '登录成功');
        }
        return $this->error('用户名或者密码错误');
    }

    /**
     * @throws Throwable
     */
    #[PostMapping(path: '/reg', middlewares: [TencentCaptchaMiddleware::class])]
    public function register(): ResponseInterface
    {
        $data      = $this->request->all();
        $validator = (new Validator())->make($data, [
            'username' => 'required',
            'email'    => 'email|required',
            'password' => 'required',
            'avatar'   => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data['password'] = md5($data['password']);
        try {
            $user = User::create($data);
            $this->session->set('user', $user->toArray());
            return $this->success([]);
        } catch (Throwable) {
            return $this->error('邮箱已经被使用');
        }
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
