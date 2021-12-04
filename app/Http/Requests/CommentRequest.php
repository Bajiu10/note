<?php

namespace App\Http\Requests;

use App\Http\Request;

class CommentRequest extends Request
{

    protected $rule = [
        'comment' => ['required' => true, 'length' => [5, 200]],
        'note_id' => ['required' => true],
        'name'    => ['max' => 10]
    ];

}