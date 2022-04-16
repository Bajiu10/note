<?php

namespace App\Model\Entities;

use Max\Database\Eloquent\Model;

class Note extends Model
{
    protected string $table = 'notes';

    public const PERMISSION_LOGIN = 1;
}
