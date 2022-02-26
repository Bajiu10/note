<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Database\Query;
use Max\Di\Annotations\Inject;

class HeartDao
{
    #[Inject]
    protected Query $query;

    /**
     * @param $ip
     *
     * @return Collection
     */
    public function getIdsByIp($ip): Collection
    {
        return $this->query->table('hearts')->where('user_id', $ip)->column('comment_id');
    }

    /**
     * @param      $commentId
     * @param null $userId
     *
     * @return bool
     */
    public function hasOneByCommentId($commentId, $userId = null): bool
    {
        $heart = $this->query->table('hearts')
                   ->where('comment_id', $commentId);
        if ($userId) {
            $heart->where('user_id', $userId);
        }

        return $heart->exists();
    }

    /**
     * @param      $commentId
     * @param null $userId
     *
     * @return int
     */
    public function deleteOneByCommentId($commentId, $userId = null): int
    {
        $heart = $this->query->table('hearts')->where('comment_id', $commentId);
        if ($userId) {
            $heart->where('user_id', $userId);
        }
        return $heart->delete();
    }

    /**
     * @param $data
     *
     * @return false|string
     */
    public function createOne($data): bool|string
    {
        return $this->query->table('hearts')->insert($data);
    }
}
