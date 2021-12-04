<?php
declare(strict_types=1);

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Http\Middleware\Common\Login;
use App\Http\Middleware\Common\Logined;
use Max\Foundation\Di\Annotations\Middleware;
use Max\Foundation\Facades\DB;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;

#[\Max\Routing\Annotations\Controller(prefix: '/', middleware: ['web'])]
class User extends Controller
{
    #[
        RequestMapping(path: 'login'),
        Middleware(Logined::class)
    ]
    public function login()
    {
        $from = $this->request->get('from', '/');
        if ($this->request->isMethod('GET')) {
            return view(config('app.theme') . '/users/login');
        }
        $user = $this->request->post(['username', 'password']);
        $user['password'] = md5($user['password']);
        if ($user = DB::table('users')
            ->where('username', '=', $user['username'])
            ->where('password', '=', $user['password'])
            ->first()
        ) {
            Session::set('user', $user);
            return redirect($from);
        } else {
            throw new \Exception('用户名或者密码错误！😢😢😢');
        }
    }

    #[
        GetMapping(path: 'logout'),
        Middleware(Login::class)
    ]
    public function logout()
    {
        Session::destroy();
        $from = $this->request->get('from', '/');
        return redirect($from);
    }
}
