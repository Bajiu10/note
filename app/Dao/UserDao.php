<?php

namespace App\Dao;

use Max\Foundation\Facades\DB;

/**
 * Class UserDao
 *
 * @package App\Dao
 */
class UserDao
{
    /**
     * @param array $credentials
     *
     * @return mixed
     */
    public function findOneByCredentials(array $credentials)
    {
        return DB::table('users')
                 ->where('username', $credentials['username'])
                 ->where('password', md5($credentials['password']))
                 ->first();
    }
}
