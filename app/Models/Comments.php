<?php

namespace App\Models;

use Max\Database\Model;
use Max\Foundation\Facades\DB;

class Comments extends Model
{
    private const NUMBER_OF_PAGES = 5;

    public function read(int $id, $page = 1, int $order = 0)
    {
        $orders       = $order ? ['hearts' => 'DESC', 'create_time' => 'DESC'] : ['create_time' => 'DESC'];
        $fields       = [
            'c.id',
            'replace(replace(replace(c.comment, \'{狗头}\', \'<img src=\"/static/img/dog.gif\" style=\"width:1.5em;height:1.5em\">\'), \'{滑稽}\', \'<img src=\"/static/img/huaji.gif\" style=\"width:1.5em;height:1.5em\">\'), \'{上吊}\', \'<img src=\"/static/img/diao.gif\" style=\"width:1.5em;height:1.5em\">\') as comment',
            'UNIX_TIMESTAMP(create_time) create_time',
            'c.name',
            'parent_id',
            'count(f.user_id) hearts'
        ];
        $comments     = DB::table('comments', 'c')
                          ->leftJoin('hearts', 'f')->on('c.id', '=', 'f.comment_id')
                          ->where('note_id', '=', $id)
                          ->whereNull('parent_id')
                          ->group('c.id')
                          ->order('hearts', 'DESC')
                          ->limit(self::NUMBER_OF_PAGES)
                          ->offset(($page - 1) * self::NUMBER_OF_PAGES)
                          ->get($fields)->toArray();
        $sub_comments = DB::table('comments', 'c')
                          ->leftJoin('hearts', 'f')->on('c.id', '=', 'f.comment_id')
                          ->whereIn('parent_id', array_column($comments, 'id') ?: [])
                          ->group('c.id')
                          ->order('hearts', 'DESC')
                          ->get($fields);
        return ['top' => $comments, 'sub' => $sub_comments];
    }

    public function has($condition)
    {
        return self::query()->where($condition)->get();
    }

    public function count($id)
    {
        return self::query()->where(['note_id' => $id])->count('*');
    }

}
