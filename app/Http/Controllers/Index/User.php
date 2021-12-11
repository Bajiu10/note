<?php
declare(strict_types=1);

namespace App\Http\Controllers\Index;

use App\Dao\UserDao;
use App\Http\Controller;
use App\Http\Middleware\Common\Login;
use App\Http\Middleware\Common\Logined;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;

/**
 * Class User
 * @package App\Http\Controllers\Index
 */
#[\Max\Routing\Annotations\Controller(prefix: '/', middleware: ['web'])]
class User extends Controller
{
    /**
     * @param UserDao $userDao
     * @return mixed
     * @throws \Exception
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
        if ($user = $userDao->findOneByCredentials($this->request->post(['username', 'password']))) {
            Session::set('user', $user);
            return redirect($this->request->get('from', '/'));
        } else {
            throw new \Exception('用户名或者密码错误！😢😢😢');
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
