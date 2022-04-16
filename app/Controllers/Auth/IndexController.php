<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Middlewares\Authentication;
use Exception;
use Max\Config\Annotations\Config;
use Max\Di\Annotations\Inject;
use Max\Http\Annotations\GetMapping;
use Max\Http\Annotations\RequestMapping;
use Max\Http\Exceptions\HttpException;
use Max\Http\Session;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use function redirect;
use function view;

/**
 * Class User
 *
 * @package App\Http\Controllers\Auth
 */
#[\Max\Http\Annotations\Controller(prefix: '/')]
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
    #[GetMapping(path: 'logout', middlewares: [Authentication::class])]
    public function logout(): ResponseInterface
    {
        $this->session->destroy();
        return redirect($this->request->get('from', '/'));
    }
}
