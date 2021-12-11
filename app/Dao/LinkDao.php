<?php

namespace App\Dao;

use Max\Foundation\Facades\DB;

/**
 * Class LinkDao
 * @package App\Dao
 */
class LinkDao
{
    public function all()
    {
        return DB::table('links')->get();
    }
}