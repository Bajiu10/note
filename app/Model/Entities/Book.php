<?php

namespace App\Model\Entities;

use Max\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Book extends Model
{
    protected string $table = 'book';
}
