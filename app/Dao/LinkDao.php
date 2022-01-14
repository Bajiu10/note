<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Foundation\Facades\DB;

/**
 * Class LinkDao
 *
 * @package App\Dao
 */
class LinkDao
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return DB::table('links')->get();
    }
}
