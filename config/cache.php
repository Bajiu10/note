<?php

return [
    'default' => 'redis',
    'stores'  => [
        //文件缓存
        'file'      => [
            'handler' => 'Max\Cache\Handlers\File',
            'options' => [
                'path' => base_path('storage/cache/app'),
            ],
        ],
        // redis缓存
        'redis'     => [
            'handler' => 'Max\Cache\Handlers\Redis',
            'options' => [
                //所有Redis的host[不区分主从]
                'host'   => [
                    '127.0.0.1',
                    '127.0.0.1',
                    '127.0.0.1',
                    '127.0.0.1',
                    '127.0.0.1',
                    '127.0.0.1',
                    '127.0.0.1',
                ],
                //端口 string / array
                'port'   => 6379,
                //密码 string / array
                'auth'   => '',
                //主Redis ID [host中主机对应数组的键]
                'master' => [0, 1, 4, 5],
                //从Redis ID [host中主机对应数组的键]
                'slave'  => [2, 3, 6]
            ],
        ],
        //memcached缓存
        'memcached' => [
            'handler' => 'Max\Cache\Handlers\Memcached',
            'options' => [
                'host' => '127.0.0.1', //主机
                'port' => 11211        //端口
            ],
        ]
    ],
];
