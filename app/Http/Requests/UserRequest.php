<?php

namespace App\Http\Requests;

use App\Http\Request;

class UserRequest extends Request
{
    protected $rule = [
        'username' => [
            'required' => true,
            'length'   => [5, 20]
        ],
        'password' => [
            'required' => true,
            'length'   => [5, 20]
        ]
    ];
}