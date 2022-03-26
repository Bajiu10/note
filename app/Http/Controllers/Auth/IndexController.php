<?php

namespace App\Http\Controllers\Auth;

use App\Dao\UserDao;
use App\Http\Controller;
use App\Http\Middlewares\Authentication;
use Exception;
use Max\Config\Annotations\Config;
use Max\Di\Annotations\Inject;
use Max\Foundation\Http\Annotations\Middleware;
use Max\Foundation\Session;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class User
 *
 * @package App\Http\Controllers\Auth
 */
#[\Max\Routing\Annotations\Controller(prefix: '/')]
class IndexController extends Controller
{
    #[Inject]
    protected Session $session;

    #[Config(key: 'app.theme')]
    protected string $theme;

    /**
     * @param UserDao $userDao
     *
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[RequestMapping(path: 'login')]
    public function login(UserDao $userDao): ResponseInterface
    {
        $userId = $this->session->get('user.id');
        if (!is_null($userId)) {
            throw new Exception('你已经登录了！😊😊😊');
        }
        return view('auth.login');
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    #[GetMapping(path: 'reg')]
    public function register(): ResponseInterface
    {
        if ($this->session->get('user.id')) {
            return redirect('/');
        }
        return view('auth.reg');
    }

    /**
     * @return ResponseInterface
     */
    #[
        GetMapping(path: 'logout'),
        Middleware(Authentication::class)
    ]
    public function logout(): ResponseInterface
    {
        $this->session->destroy();
        return redirect($this->request->get('from', '/'));
    }
}
