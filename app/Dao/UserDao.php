<?php

namespace App\Dao;

use Max\Database\Query;
use Max\Di\Annotations\Inject;

class UserDao
{
    #[Inject]
    protected Query $query;

    /**
     * @param array $credentials
     *
     * @return mixed
     */
    public function findOneByCredentials(array $credentials)
    {
        return $this->query->table('users')
                           ->where('username', $credentials['username'])
                           ->where('password', md5($credentials['password']))
                           ->first();
    }
}
