<?php

namespace Psr\Http\Message {

    use Max\Foundation\Http\{Request, Response};

    /**
     * @mixin Request
     */
    interface ServerRequestInterface
    {

    }

    /**
     * @mixin Response
     */
    interface ResponseInterface
    {

    }
}

namespace Max\Routing\Annotations {
    class GetMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array             $middlewares
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param array             $patterns         变量规则
         */
        public function __construct(string $path, ?string $name = null, array $middlewares = [], array|string|null $allowCrossDomain = null, array $patterns = [])
        {
        }
    }

    class PostMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array             $middlewares
         * @param array             $patterns
         * @param array|string|null $allowCrossDomain 跨域列表
         */
        public function __construct(string $path, ?string $name = null, array $middlewares = [], array $patterns = [], array|string|null $allowCrossDomain = null)
        {
        }
    }

    class PutMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array             $middlewares
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param array             $patterns
         */
        public function __construct(string $path, ?string $name = null, array $middlewares = [], array|string|null $allowCrossDomain = null, array $patterns = [])
        {
        }
    }

    class DeleteMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array             $middlewares
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param array             $patterns
         */
        public function __construct(string $path, ?string $name = null, array $middlewares = [], array|string|null $allowCrossDomain = null, array $patterns = [])
        {
        }
    }

    class PatchMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name
         * @param array             $middlewares
         * @param array|string|null $allowCrossDomain
         * @param array             $patterns
         */
        public function __construct(string $path, ?string $name = null, array $middlewares = [], array|string|null $allowCrossDomain = null, array $patterns = [])
        {
        }
    }

    class RequestMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name
         * @param array             $middlewares
         * @param array|string|null $allowCrossDomain
         * @param array             $patterns
         * @param array             $methods
         */
        public function __construct(string $path, ?string $name = null, array $middlewares = [], array|string|null $allowCrossDomain = null, array $patterns = [], array $methods = ['GET', 'POST', 'HEAD'])
        {
        }
    }

    class Controller
    {
        /**
         * @param string $prefix
         * @param array  $middlewares
         */
        public function __construct(string $prefix = '', array $middlewares = [])
        {
        }
    }
}

namespace Max\Di\Annotations {
    class Inject
    {
        /**
         * @param string|null $id
         */
        public function __construct(?string $id = null)
        {
        }
    }
}

namespace Max\Config\Annotations {
    class Config
    {
        /**
         * @param string $key
         * @param null   $default
         */
        public function __construct(string $key, $default = null)
        {
        }
    }
}

namespace Max\Foundation\Http\Annotations {
    class Middleware
    {
        /**
         * @param ...$middlewares
         */
        public function __construct(...$middlewares)
        {
        }
    }
}

namespace Psr\Container {

    use Max\Foundation\App;

    /**
     * @mixin App
     */
    interface ContainerInterface
    {

    }
}

namespace Psr\SimpleCache {

    use Max\Foundation\Cache;

    /**
     * @mixin Cache
     */
    interface CacheInterface
    {

    }
}
