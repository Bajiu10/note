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
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string            $ext
         * @param array             $where
         */
        public function __construct(string $path, ?string $name = null, array|string|null $allowCrossDomain = null, string $ext = '', array $where = [])
        {
        }
    }

    class PostMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string            $ext
         * @param array             $where
         */
        public function __construct(string $path, ?string $name = null, array|string|null $allowCrossDomain = null, string $ext = '', array $where = [])
        {
        }
    }

    class PutMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string            $ext
         * @param array             $where
         */
        public function __construct(string $path, ?string $name = null, array|string|null $allowCrossDomain = null, string $ext = '', array $where = [])
        {
        }
    }

    class DeleteMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name             别名
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string            $ext
         * @param array             $where
         */
        public function __construct(string $path, ?string $name = null, array|string|null $allowCrossDomain = null, string $ext = '', array $where = [])
        {
        }
    }

    class PatchMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name
         * @param array|string|null $allowCrossDomain
         * @param string            $ext
         * @param array             $where
         */
        public function __construct(string $path, ?string $name = null, array|string|null $allowCrossDomain = null, string $ext = '', array $where = [])
        {
        }
    }

    class RequestMapping
    {
        /**
         * @param string            $path
         * @param string|null       $name
         * @param array|string|null $allowCrossDomain
         * @param string            $ext
         * @param array             $where
         * @param array             $methods
         */
        public function __construct(string $path, ?string $name = null, array|string|null $allowCrossDomain = null, string $ext = '', array $where = [], array $methods = ['GET', 'POST', 'HEAD'])
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

    use Max\Cache\Cache;

    /**
     * @mixin Cache
     */
    interface CacheInterface
    {

    }
}
