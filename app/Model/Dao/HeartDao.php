<?php

namespace App\Model\Dao;

use App\Model\Entities\Heart;
use Max\Aop\Annotation\Inject;
use Max\Database\Manager;
use Swoole\Exception;
use Throwable;

class HeartDao
{
    #[Inject]
    protected Manager $query;

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
        return Heart::where('comment_id', $commentId)
                    ->when($userId, fn($builder) => $builder->where('user_id', $userId))
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
            ->when($userId, fn($builder) => $builder->where('user_id', $userId))->delete();
    }

    /**
     * @param $data
     *
     * @return false|string
     * @throws Throwable
     */
    public function createOne($data): bool|string
    {
        return $this->query->table('hearts')->insert($data);
    }
}
