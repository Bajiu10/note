<?php


namespace App\Dao;


use Max\Foundation\Facades\DB;

/**
 * Class HeartDao
 * @package App\Dao
 */
class HeartDao
{
    public function hasOneByCommentId($commentId, $userId = null)
    {
        $heart = DB::table('hearts')
            ->where('comment_id', '=', $commentId);
        if ($userId) {
            $heart->where('user_id', '=', $userId);
        }

        return $heart->exists();
    }

    public function deleteOneByCommentId($commentId, $userId = null)
    {
        $heart = DB::table('hearts')->where('comment_id', '=', $commentId);
        if ($userId) {
            $heart->where('user_id', '=', $userId);
        }
        return $heart->delete();
    }

    public function createOne($data)
    {
        return DB::table('hearts')->insert($data);
    }
}