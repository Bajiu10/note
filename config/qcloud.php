<?php

return [
    'user'    => [
        'secret_id'  => env('QCLOUD.USER_SECRET_ID'),
        'secret_key' => env('QCLOUD.USER_SECRET_KEY'),
    ],
    'captcha' => [
        'app_id'     => env('QCLOUD.CAPTCHA_APP_ID'),
        'secret_key' => env('QCLOUD.CAPTCHA_SECRET_KEY'),
    ]
];
