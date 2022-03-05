<?php

namespace App\Dao;

use Max\Database\Collection;
use Max\Database\Query;
use Max\Di\Annotations\Inject;
use Swoole\Exception;
use Throwable;

class HeartDao
{
    #[Inject]
    protected Query $query;

    /**
     * @param $ip
     *
     * @return Collection
     * @throws Exception
     * @throws Throwable
     */
    public function getIdsByIp($ip): Collection
    {
        return $this->query
            ->table('hearts')
            ->where('user_id', $ip)
            ->column('comment_id');
    }

    /**
     * @param      $commentId
     * @param null $userId
     *
     * @return bool
     * @throws Exception
     * @throws Throwable
     */
    public function hasOneByCommentId($commentId, $userId = null): bool
    {
        return $this->query
            ->table('hearts')
            ->where('comment_id', $commentId)
            ->when($userId, function(Query\Builder $builder) use ($userId) {
                return $builder->where('user_id', $userId);
            })
            ->exists();
    }

    /**
     * @param      $commentId
     * @param null $userId
     *
     * @return int
     * @throws Exception
     * @throws Throwable
     */
    public function deleteOneByCommentId($commentId, $userId = null): int
    {
        return $this->query
            ->table('hearts')
            ->where('comment_id', $commentId)
            ->when($userId, function(Query\Builder $builder) use ($userId) {
                return $builder->where('user_id', $userId);
            })->delete();
    }

    /**
     * @param $data
     *
     * @return false|string
     * @throws Exception
     * @throws Throwable
     */
    public function createOne($data): bool|string
    {
        return $this->query->table('hearts')->insert($data);
    }
}
