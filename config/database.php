<?php

return [
    'default'     => 'mysql',
    'connections' => [
        'mysql' => [
            // 驱动
            'driver'   => 'mysql',
            // 主机地址
            'host'     => env('database.host', 'localhost'),
            // 数据库用户名
            'user'     => env('database.user', 'user'),
            // 数据库密码
            'password' => env('database.pass', 'pass'),
            // 数据库名
            'database' => env('database.dbname', 'name'),
            // 端口
            'port'     => env('database.port', 3306),
            // 额外设置
            'options'  => [],
            // 编码
            'charset'  => env('database.charset', 'utf8mb4'),
            // 数据表前缀
            'prefix'   => '',
            // 连接池内最大连接数量
            'poolSize' => 200,
        ],
    ],
    'redis'       => [
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
    ]
];
