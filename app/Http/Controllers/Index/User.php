<?php
declare(strict_types=1);

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Http\Middleware\Common\Logined;
use Max\Foundation\Facades\DB;
use Max\Foundation\Facades\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;

#[\Max\Routing\Annotations\Controller(prefix: '/', middleware: ['web', Logined::class])]
class User extends Controller
{
    #[RequestMapping(path: 'login')]
    public function login()
    {
        $from = $this->request->get('from', '/');
        if ($this->request->isMethod('GET')) {
            return view(config('app.theme') . '/users/login');
        }
        $user             = $this->request->post(['username', 'password']);
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

    #[GetMapping(path: 'logout')]
    public function logout()
    {
        Session::destroy();
        $from = $this->request->get('from', '/');
        return redirect($from);
    }
}
