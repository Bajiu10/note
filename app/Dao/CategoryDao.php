<?php

namespace App\Dao;

use Max\Foundation\Facades\DB;

/**
 * Class CategoryDao
 * @package App\Dao
 */
class CategoryDao
{
    /**
     * @param string $order
     * @return \Max\Database\Collection
     */
    public function all($order = 'id')
    {
        return DB::table('categories')->order($order)->get();
    }
}