<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Http\Middlewares\Authentication;
use Exception;
use Max\Config\Annotations\Config;
use Max\Di\Annotations\Inject;
use Max\Foundation\Http\Annotations\Middleware;
use Max\Foundation\Session;
use Max\Foundation\Http\Annotations\GetMapping;
use Max\Foundation\Http\Annotations\RequestMapping;
use Max\Http\Exceptions\HttpException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class User
 *
 * @package App\Http\Controllers\Auth
 */
#[\Max\Foundation\Http\Annotations\Controller(prefix: '/')]
class IndexController extends Controller
{
    #[Inject]
    protected Session $session;

    #[Config(key: 'app.theme')]
    protected string $theme;

    /**
     * @return ResponseInterface
     * @throws Exception|Throwable
     */
    #[RequestMapping(path: 'login')]
    public function login(): ResponseInterface
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
     * @throws HttpException
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
