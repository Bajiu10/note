<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Max\Database\Query;
use Max\Routing\Annotations\Controller;
use Max\Routing\Annotations\GetMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: '/')]
class Link extends ApiController
{
    #[GetMapping(path: 'api/link')]
    public function index(Query $query): ResponseInterface
    {
        $links = $query->table('links')->get()->toArray();

        return $this->success($links);
    }
}
