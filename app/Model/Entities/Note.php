<?php

namespace App\Model\Entities;

use Max\Database\Eloquent\Model;

/**
 * @property int $permission 权限
 */
class Note extends Model
{
    protected string $table = 'notes';

    public const PERMISSION_LOGIN = 1;

    public function isPublic(): bool
    {
        return $this->permission != self::PERMISSION_LOGIN;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'id');
    }
}
