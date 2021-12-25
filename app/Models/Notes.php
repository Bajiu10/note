<?php

namespace App\Models;

use Max\Database\Model;
use Max\Foundation\Facades\DB;

class Notes extends Model
{
    public function hots($limit = 8)
    {
        return DB::table('notes')
                 ->order('hits', 'DESC')
                 ->order('update_time', 'DESC')
                 ->order('create_time', 'DESC')
                 ->whereNull('delete_time')
                 ->limit($limit)
                 ->get(['title', 'id'])
                 ->toArray();
    }

    public function list($page, $limit)
    {
        return DB::table('notes', 'n')
                 ->leftJoin('categories', 'c')
                 ->on('n.cid', 'c.id')
                 ->whereNull('delete_time')
                 ->order('sort', 'DESC')
                 ->order('create_time', 'DESC')
                 ->limit($limit)->offset(($page - 1) * $limit)
                 ->get(['n.id', 'n.thumb', 'n.title', 'n.abstract', 'n.text', 'n.hits', 'UNIX_TIMESTAMP(`n`.`create_time`) create_time', 'c.name type']);
    }

    public function search($kw, $limit, $offset)
    {
        return DB::table('notes', 'n')
                 ->leftJoin('categories', 'c')
                 ->on('n.cid', 'c.id')
                 ->whereNull('n.delete_time')
                 ->whereRaw('(`n`.`title` LIKE ? OR MATCH(`n`.`title`,`n`.`text`) AGAINST(?))', ["%{$kw}%", "{$kw}"])->order('create_time', 'DESC')
                 ->limit($limit)
                 ->offset($offset)
                 ->get(['n.title title, n.text text, n.abstract abstract, n.hits hits, n.id id, n.thumb,UNIX_TIMESTAMP(`n`.`create_time`) create_time, c.name type']);
    }

    public function searchCount($kw)
    {
        return DB::table('notes')
                 ->whereNull('delete_time')
                 ->whereRaw('(`title` LIKE ? OR MATCH(`title`,`text`) AGAINST(?))', ["%{$kw}%", "{$kw}"])
                 ->count(1);
    }

    public function getRecommended($cid, $id): array
    {
        return DB::table('notes', 'n')
                 ->leftJoin('categories', 'c')
                 ->on('n.cid', 'c.id')
                 ->whereNull('delete_time')
                 ->where('n.cid', $cid)
                 ->where('n.id', $id, '!=')
                 ->order('rand()')
                 ->limit(3)
                 ->get(['n.id id', 'n.text text', 'n.title title', 'c.name type', 'n.thumb'])
                 ->map(function($value) {
                     $value['thumb'] = $value['thumb'] ?: '/static/bg/bg' . rand(1, 33) . '.jpg';
                     return $value;
                 })
                 ->toArray();
    }

}
