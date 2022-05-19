<?php

namespace App\Model\Entities;

use Max\Database\Eloquent\Model;

/**
 * @property string $username
 * @property string $avatar
 */
class User extends Model
{
    /**
     * @var string
     */
    protected string $table = 'users';

    /**
     * @var array|string[]
     */
    protected array $cast = [
        'id' => 'int',
        'age' => 'int'
    ];

    /**
     * @var array|string[]
     */
    protected array $fillable = [
        'username',
        'email',
        'avatar',
        'password'
    ];

    /**
     * @var array|string[]
     */
    protected array $hidden = [
        'password',
    ];
}
