<?php
declare(strict_types=1);

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use Max\Foundation\Facades\DB;
use Max\Foundation\Facades\Session;

class User extends Controller
{
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

    public function logout()
    {
        Session::destroy();
        $from = $this->request->get('from', '/');
        return redirect($from);
    }
}
