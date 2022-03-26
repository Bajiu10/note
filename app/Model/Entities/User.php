<?php

namespace App\Model\Entities;

use Max\Database\Eloquent\Model;

/**
 * @property string $username
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
        'age' => 'int'
    ];

    /**
     * @var array|string[]
     */
    protected array $fillable = [
        'username',
        'email',
        'password'
    ];

    /**
     * @var array|string[]
     */
    protected array $hidden = [
        'password',
    ];
}
