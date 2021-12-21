<?php

return [
    'exception_handler' => \App\Exceptions\Handler::class,
    'cookie'            => [
        'expires'  => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
        'httponly' => false,
        'samesite' => '',
    ],
];
