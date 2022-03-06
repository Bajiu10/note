<?php

namespace App\Http\Controllers\Auth;

use App\Dao\UserDao;
use App\Http\Controller;
use App\Http\Middlewares\Login;
use App\Http\Middlewares\Logined;
use App\Http\Middlewares\SessionMiddleware;
use Exception;
use Max\Config\Annotations\Config;
use Max\Di\Annotations\Inject;
use Max\Di\Exceptions\NotFoundException;
use Max\Routing\Annotations\GetMapping;
use Max\Routing\Annotations\RequestMapping;
use Max\Server\Http\Annotations\Middleware;
use Max\Session\Session;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Throwable;

/**
 * Class User
 *
 * @package App\Http\Controllers\Auth
 */
#[\Max\Routing\Annotations\Controller(prefix: '/', middlewares: [SessionMiddleware::class])]
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
    #[
        RequestMapping(path: 'login'),
        Middleware(Logined::class)
    ]
    public function login(UserDao $userDao): ResponseInterface
    {
        if ($this->request->isMethod('GET')) {
            return view('auth.login');
        }
        if ($user = $userDao->findOneByCredentials($this->request->post(['username', 'password']))) {
            $this->session->set('user', $user);
            return redirect($this->request->get('from', '/'));
        } else {
            throw new Exception('用户名或者密码错误！😢😢😢');
        }
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    #[GetMapping(path: 'reg')]
    public function register(): ResponseInterface
    {
        return view('auth.reg');
    }

    /**
     * @return ResponseInterface
     */
    #[
        GetMapping(path: 'logout'),
        Middleware(Login::class)
    ]
    public function logout(): ResponseInterface
    {
        $this->session->destroy();
        return redirect($this->request->get('from', '/'));
    }
}
