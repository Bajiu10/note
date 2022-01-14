<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Foundation\Facades\DB;

/**
 * Class CommentDao
 *
 * @package App\Dao
 */
class CommentDao
{
    /**
     * @param $id
     *
     * @return int
     */
    public function amountOfOneNote($id): int
    {
        return DB::table('comments')->where('note_id', $id)->count($id);
    }

    /**
     * @param int    $limit
     * @param string $order
     * @param string $seq
     *
     * @return Collection
     */
    public function getSome(int $limit = 5, string $order = 'create_time', string $seq = 'DESC'): Collection
    {
        return DB::table('comments')->order($order, $seq)->limit($limit)->get();
    }

    /**
     * @param $data
     *
     * @return false|string
     */
    public function createOne($data): bool|string
    {
        return DB::table('comments')->insert($data);
    }

    /**
     * @param int $id
     * @param int $page
     * @param int $order
     * @param int $pageSize
     *
     * @return array
     */
    public function read(int $id, int $page = 1, int $order = 0, int $pageSize = 5): array
    {
        $orders       = $order ? ['hearts', 'DESC'] : ['create_time', 'DESC'];
        $fields       = [
            'c.id',
            'c.comment as comment',
            'UNIX_TIMESTAMP(create_time) create_time',
            'c.name',
            'parent_id',
            'count(f.user_id) hearts'
        ];
        $comments     = DB::table('comments', 'c')
                          ->leftJoin('hearts', 'f')->on('c.id', 'f.comment_id')
                          ->where('note_id', $id)
                          ->whereNull('parent_id')
                          ->group('c.id')
                          ->order(...$orders)
                          ->limit($pageSize)
                          ->offset(($page - 1) * $pageSize)
                          ->get($fields)
                          ->toArray();
        $sub_comments = DB::table('comments', 'c')
                          ->leftJoin('hearts', 'f')
                          ->on('c.id', 'f.comment_id')
                          ->whereIn('parent_id', array_column($comments, 'id') ?: [])
                          ->group('c.id')
                          ->order('hearts', 'DESC')
                          ->get($fields);
        return ['top' => $comments, 'sub' => $sub_comments];
    }
}
