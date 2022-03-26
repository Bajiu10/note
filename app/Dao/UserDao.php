<?php

namespace App\Dao;

use Max\Database\Query;
use Max\Di\Annotations\Inject;
use Swoole\Exception;
use Throwable;

class UserDao
{
    #[Inject]
    protected Query $query;

    /**
     * @param array $credentials
     *
     * @return mixed
     * @throws Exception
     * @throws Throwable
     */
    public function findOneByCredentials(array $credentials): mixed
    {
        return $this->query
            ->table('users')
            ->where('email', $credentials['email'])
            ->where('password', md5($credentials['password']))
            ->first();
    }
}
