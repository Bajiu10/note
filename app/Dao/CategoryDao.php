<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Foundation\Facades\DB;

/**
 * Class CategoryDao
 * @package App\Dao
 */
class CategoryDao
{
    /**
     * @param string $order
     *
     * @return Collection
     */
    public function all(string $order = 'id'): Collection
    {
        return DB::table('categories')->order($order)->get();
    }
}
