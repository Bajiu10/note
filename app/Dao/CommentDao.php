<?php

namespace App\Dao;

use Max\Foundation\Facades\DB;

/**
 * Class CommentDao
 *
 * @package App\Dao
 */
class CommentDao
{
    public function amountOfOneNote($id)
    {
        return DB::table('comments')->where('note_id', $id)->count($id);
    }

    public function getSome($limit = 5, $order = 'create_time', $seq = 'DESC')
    {
        return DB::table('comments')->order($order, $seq)->limit($limit)->get();
    }

    public function createOne($data)
    {
        return DB::table('comments')->insert($data);
    }

}
