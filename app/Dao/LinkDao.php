<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Database\Query;
use Max\Di\Annotations\Inject;

class LinkDao
{
    #[Inject]
    protected Query $query;

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->query->table('links')->get();
    }
}
