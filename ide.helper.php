<?php

namespace Psr\Http\Message {

    use Max\Server\Http\Response;
    use App\Lib\ServerRequest;

    /**
     * @mixin ServerRequest
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
         * @param string $path
         * @param array  $middlewares
         */
        public function __construct(string $path, array $middlewares = [])
        {
        }
    }

    class PostMapping
    {
        /**
         * @param string $path
         * @param array  $middlewares
         */
        public function __construct(string $path, array $middlewares = [])
        {
        }
    }

    class PutMapping
    {
        /**
         * @param string $path
         * @param array  $middlewares
         */
        public function __construct(string $path, array $middlewares = [])
        {
        }
    }

    class DeleteMapping
    {
        /**
         * @param string $path
         * @param array  $middlewares
         */
        public function __construct(string $path, array $middlewares = [])
        {
        }
    }

    class PatchMapping
    {
        /**
         * @param string $path
         * @param array  $middlewares
         */
        public function __construct(string $path, array $middlewares = [])
        {
        }
    }

    class RequestMapping
    {
        /**
         * @param string $path
         * @param array  $middlewares
         * @param array  $methods
         */
        public function __construct(string $path, array $middlewares = [], array $methods = ['GET', 'POST', 'HEAD'])
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

namespace Psr\Container {

    use Max\Di\Container;

    /**
     * @mixin Container
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
