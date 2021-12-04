<?php

namespace App\Http\Requests;

use App\Http\Request;

class NoteRequest extends Request
{
    protected $rule = [
        'title' => ['required' => true]
    ];
}