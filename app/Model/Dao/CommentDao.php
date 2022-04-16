<?php

namespace App\Model\Dao;

use Max\Database\Collection;
use Max\Database\Query;
use Max\Di\Annotations\Inject;
use Psr\Http\Message\ServerRequestInterface;
use function make;

class CommentDao
{
    #[Inject]
    protected Query $query;

    /**
     * @param int    $limit
     * @param string $order
     * @param string $seq
     *
     * @return Collection
     */
    public function getSome(int $limit = 5, string $order = 'create_time', string $seq = 'DESC'): Collection
    {
        return $this->query->table('comments')->order($order, $seq)->limit($limit)->get();
    }

    /**
     * @param ServerRequestInterface $request
     * @param int                    $id
     * @param int                    $pageSize
     *
     * @return array
     */
    public function read(ServerRequestInterface $request, int $id, int $pageSize = 5): array
    {
        $page     = (int)$request->get('page', 1);
        $order    = $request->get('order', 0);
        $orders   = $order ? ['hearts', 'DESC'] : ['create_time', 'DESC'];
        $fields   = [
            'c.id',
            'c.comment as comment',
            'UNIX_TIMESTAMP(create_time) create_time',
            'c.name',
            'parent_id',
            'count(f.user_id) hearts'
        ];
        $hearts   = make(HeartDao::class)->getIdsByIp($request->ip())->toArray();
        $comments = $this->query->table('comments', 'c')
                                ->leftJoin('hearts', 'f')->on('c.id', 'f.comment_id')
                                ->where('note_id', $id)
                                ->whereNull('parent_id')
                                ->group('c.id')
                                ->order(...$orders)
                                ->limit($pageSize)
                                ->offset(($page - 1) * $pageSize)
                                ->get($fields);
        $children = $this->query->table('comments', 'c')
                                ->leftJoin('hearts', 'f')
                                ->on('c.id', 'f.comment_id')
                                ->whereIn('parent_id', $comments->pluck('id')->toArray())
                                ->group('c.id')
                                ->order('hearts', 'DESC')
                                ->get($fields)
                                ->map(function($item) use ($hearts) {
                                    $item['hearted'] = in_array($item['id'], $hearts);
                                    return $item;
                                });
        return $comments->map(function($item) use ($children, $hearts) {
            $item['hearted']  = in_array($item['id'], $hearts);
            $item['children'] = $children->where('parent_id', $item['id'])->toArray();
            return $item;
        })->toArray();
    }
}
