<?php

namespace App\Model\Entities;

use Max\Database\Eloquent\Model;

/**
 * @property string $username
 */
class User extends Model
{
    protected string $table = 'users';

    protected array $fillable = [
        'username',
        'email',
        'password'
    ];
}
