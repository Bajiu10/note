<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Database\Query;
use Max\Di\Annotations\Inject;

class CategoryDao
{
    #[Inject]
    protected Query $query;

    /**
     * @param string $order
     *
     * @return Collection
     */
    public function all(string $order = 'id'): Collection
    {
        return $this->query->table('categories')->order($order)->get();
    }
}
