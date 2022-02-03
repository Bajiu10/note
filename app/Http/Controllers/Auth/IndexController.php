<?php

namespace App\Http\Controllers\Auth;

use App\Dao\UserDao;
use App\Http\Controller;
use App\Http\Middleware\Login;
use App\Http\Middleware\Logined;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * Class User
 *
 * @package App\Http\Controllers\Auth
 */
#[\Max\Routing\Annotations\Controller(prefix: '/', middlewares: ['web'])]
class IndexController extends Controller
{
    /**
     * @param UserDao $userDao
     *
     * @return ResponseInterface
     * @throws Exception|\Throwable
     */
    #[
        RequestMapping(path: 'login'),
        Middleware(Logined::class)
    ]
    public function login(UserDao $userDao)
    {
        if ($this->request->isMethod('GET')) {
            return view(config('app.theme') . '/users/login');
        }
        dump($this->request->input());
        if ($user = $userDao->findOneByCredentials($this->request->post(['username', 'password']))) {
            Session::set('user', $user);
            return redirect($this->request->get('from', '/'));
        } else {
            throw new Exception('用户名或者密码错误！😢😢😢');
        }
    }

    /**
     * @return mixed
     */
    #[
        GetMapping(path: 'logout'),
        Middleware(Login::class)
    ]
    public function logout()
    {
        Session::destroy();
        return redirect($this->request->get('from', '/'));
    }
}
