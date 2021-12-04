<?php

namespace Max\Routing\Annotations {
    class GetMapping
    {
        /**
         * @param string            $path
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string|null       $alias            别名
         */
        public function __construct(string $path, ?string $alias = null, array|string|null $allowCrossDomain = null)
        {
        }
    }

    class PostMapping
    {
        /**
         * @param string            $path
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string|null       $alias            别名
         */
        public function __construct(string $path, ?string $alias = null, array|string|null $allowCrossDomain = null)
        {
        }
    }

    class PutMapping
    {
        /**
         * @param string            $path
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string|null       $alias            别名
         */
        public function __construct(string $path, ?string $alias = null, array|string|null $allowCrossDomain = null)
        {
        }
    }

    class DeleteMapping
    {
        /**
         * @param string            $path
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string|null       $alias            别名
         */
        public function __construct(string $path, ?string $alias = null, array|string|null $allowCrossDomain = null)
        {
        }
    }

    class PatchMapping
    {
        /**
         * @param string            $path
         * @param array|string|null $allowCrossDomain 跨域列表
         * @param string|null       $alias            别名
         */
        public function __construct(string $path, ?string $alias = null, array|string|null $allowCrossDomain = null)
        {
        }
    }

    class RequestMapping
    {
        /**
         * @param string            $path
         * @param array|string|null $allowCrossDomain
         * @param array|string[]    $methods
         * @param string|null       $alias
         */
        public function __construct(string $path, ?string $alias = null, array|string|null $allowCrossDomain = null, array $methods = ['GET', 'POST', 'HEAD'])
        {
        }
    }

    class Controller
    {
        /**
         * @param string       $prefix
         * @param array|string $middleware
         */
        public function __construct(string $prefix = '', array|string $middleware = [])
        {
        }
    }
}

namespace Max\Di\Annotations {
    class Inject
    {
        /**
         * @param string|null $class
         */
        public function __construct(?string $class = null)
        {
        }
    }

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

namespace Max\Http\Annotations {
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