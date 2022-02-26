<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Database\Query;
use Max\Di\Annotations\Inject;

class NoteDao
{
    #[Inject]
    protected Query $query;
    
    /**
     * @param      $id
     * @param null $userId
     *
     * @return mixed
     */
    public function findOne($id, $userId = null): mixed
    {
        $note = $this->query->table('notes')
                  ->leftJoin('categories')
                  ->on('categories.id', 'notes.cid')
                  ->where('notes.id', $id)
                  ->whereNull('notes.delete_time');

        if ($userId) {
            $note->where('user_id', $userId);
        }
        return $note->first([
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
    }

    /**
     * @param $id
     * @param $old
     */
    public function incrHits($id, $old)
    {
        $this->query->table('notes')->where('id', $id)
          ->update(['hits' => $old + 1]);
    }

    /**
     * @param $userId
     * @param $data
     *
     * @return false|string
     */
    public function createOne($userId, $data): bool|string
    {
        $data['permission'] = 'on' == $data['permission'] ? 0 : 1;
        if (empty($data['abstract'])) {
            $data['abstract'] = substr($data['text'], 0, 300);
        }
        $data['user_id']     = $userId;
        $data['update_time'] = date('Y-m-d H:i:s');
        return $this->query->table('notes')->insert($data);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return int
     */
    public function updateOne($id, $data): int
    {
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['permission']  = 'on' == $data['permission'] ? 0 : 1;
        if (empty($data['abstract'])) {
            $data['abstract'] = substr($data['text'], 0, 300);
        }
        return $this->query->table('notes')->where('id', $id)->update($data);
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return int
     */
    public function deleteOne($id, $userId): int
    {
        return $this->query->table('notes')
                 ->where('id', $id)
                 ->where('user_id', $userId)
                 ->update(['delete_time' => date('Y-m-d H:i:s')]);
    }

    /**
     * @param     $page
     * @param int $limit
     *
     * @return Collection
     */
    public function getSome($page, int $limit = 8): Collection
    {
        return $this->query->table('notes', 'n')
                 ->leftJoin('categories', 'c')->on('n.cid', 'c.id')
                 ->whereNull('delete_time')
                 ->order('sort', 'DESC')
                 ->order('update_time', 'DESC')
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
    public function recommend(int $limit = 8): array
    {
        return $this->query->table('notes')
                 ->order('hits', 'DESC')
                 ->order('update_time', 'DESC')
                 ->order('create_time', 'DESC')
                 ->whereNull('delete_time')
                 ->limit($limit)
                 ->get(['title', 'id'])
                 ->toArray();
    }


    /**
     * @param $cid
     * @param $id
     *
     * @return array
     */
    public function getRecommended($cid, $id): array
    {
        return $this->query->table('notes', 'n')
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

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->query->table('notes')->count();
    }

    /**
     * @param     $kw
     * @param int $limit
     * @param int $offset
     *
     * @return Collection
     */
    public function search($kw, int $limit = 8, int $offset = 0): Collection
    {
        return $this->query->table('notes', 'n')
                 ->leftJoin('categories', 'c')->on('n.cid', 'c.id')
                 ->whereNull('n.delete_time')
                 ->whereRaw('(`n`.`title` like ? OR MATCH(`n`.`text`) AGAINST(?))', ["%{$kw}%", "{$kw}"])->order('create_time', 'DESC')
                 ->order('update_time', 'DESC')
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
    public function countSearch($kw): int
    {
        return $this->query->table('notes')
                 ->whereNull('delete_time')
                 ->whereRaw('(`title` like ? OR MATCH(`text`) AGAINST(?))', ["%{$kw}%", "{$kw}"])
                 ->count(1);
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function hots(int $limit = 8): array
    {
        return $this->query->table('notes')
                 ->order('hits', 'DESC')
                 ->order('update_time', 'DESC')
                 ->order('create_time', 'DESC')
                 ->whereNull('delete_time')
                 ->limit($limit)
                 ->get(['title', 'id'])
                 ->toArray();
    }
}
