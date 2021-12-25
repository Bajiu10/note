<?php

namespace App\Dao;

use Max\Foundation\Facades\DB;

/**
 * Class NoteDao
 *
 * @package App\Dao
 */
class NoteDao
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOne($id, $userId = null)
    {
        $note = DB::table('notes')
                  ->leftJoin('categories')
                  ->on('categories.id', 'notes.cid')
                  ->where('notes.id', $id)
                  ->whereNull('notes.delete_time');

        if ($userId) {
            $note->where('user_id', $userId);
        }
        $note         = $note->first([
            'title',
            'notes.id',
            'categories.name category',
            'UNIX_TIMESTAMP(`update_time`) update_time',
            'text',
            'hits',
            'permission',
            'tags',
            'thumb',
            'abstract',
            'UNIX_TIMESTAMP(`create_time`) create_time',
            'user_id',
            'cid'
        ]);

        return $note;
    }

    /**
     * @param $id
     */
    public function incrHits($id, $old)
    {
        DB::table('notes')->where('id', $id)
          ->update(['hits' => $old + 1]);
    }

    /**
     * @param $userId
     * @param $data
     *
     * @return false|string
     */
    public function createOne($userId, $data)
    {
        $data['permission'] = 'on' == $data['permission'] ? 0 : 1;
        if (empty($data['abstract'])) {
            $data['abstract'] = substr($data['text'], 0, 300);
        }
        $data['user_id'] = $userId;
        return DB::table('notes')->insert($data);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return int
     */
    public function updateOne($id, $data)
    {
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['permission']  = 'on' == $data['permission'] ? 0 : 1;
        if (empty($data['abstract'])) {
            $data['abstract'] = substr($data['text'], 0, 300);
        }
        return DB::table('notes')->where('id', $id)->update($data);
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return int
     */
    public function deleteOne($id, $userId)
    {
        return DB::table('notes')
                 ->where('id', $id)
                 ->where('user_id', $userId)
                 ->update(['delete_time' => date('Y-m-d H:i:s')]);
    }

    /**
     * @param     $page
     * @param int $limit
     *
     * @return \Max\Database\Collection
     */
    public function getSome($page, $limit = 8)
    {
        return DB::table('notes', 'n')
                 ->leftJoin('categories', 'c')->on('n.cid', 'c.id')
                 ->whereNull('delete_time')
                 ->order('sort', 'DESC')
                 ->order('create_time', 'DESC')
                 ->limit($limit)->offset(($page - 1) * $limit)
                 ->get(['n.id', 'n.thumb', 'n.title', 'n.abstract', 'n.permission', 'n.text', 'n.hits', 'UNIX_TIMESTAMP(`n`.`create_time`) create_time', 'c.name type'])
                 ->map(function($value) {
                     $value['thumb'] = $value['thumb'] ?: '/static/bg/bg' . rand(1, 33) . '.jpg';
                     return $value;
                 });
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function recommend($limit = 8)
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

    /**
     * @return int
     */
    public function getAmount()
    {
        return DB::table('notes')->count();
    }

    /**
     * @param     $kw
     * @param int $limit
     * @param int $offset
     *
     * @return \Max\Database\Collection
     */
    public function search($kw, $limit = 8, $offset = 0)
    {
        return DB::table('notes', 'n')
                 ->leftJoin('categories', 'c')->on('n.cid', 'c.id')
                 ->whereNull('n.delete_time')
                 ->whereRaw('(`n`.`title` LIKE ? OR MATCH(`n`.`title`,`n`.`text`) AGAINST(?))', ["%{$kw}%", "{$kw}"])->order('create_time', 'DESC')
                 ->limit($limit)
                 ->offset($offset)
                 ->get(['n.title title, n.text text, n.permission, n.abstract abstract, n.hits hits, n.id id, n.thumb,UNIX_TIMESTAMP(`n`.`create_time`) create_time, c.name type'])
                 ->map(function($value) {
                     $value['thumb'] = $value['thumb'] ?: '/static/bg/bg' . rand(1, 33) . '.jpg';
                     return $value;
                 });
    }

    /**
     * @param $kw
     *
     * @return int
     */
    public function countSearch($kw)
    {
        return DB::table('notes')
                 ->whereNull('delete_time')
                 ->whereRaw('(`title` LIKE ? OR MATCH(`title`,`text`) AGAINST(?))', ["%{$kw}%", "{$kw}"])
                 ->count(1);
    }
}
