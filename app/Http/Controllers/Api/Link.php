<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Max\Foundation\Facades\DB;
use Max\Routing\Annotations\Controller;
use Max\Routing\Annotations\GetMapping;

#[Controller(prefix: '/', middlewares: ['api'])]
class Link extends ApiController
{
    #[GetMapping(path: 'api/link')]
    public function index()
    {
        $links = DB::table('links')->get()->toArray();

        return $this->success($links);
    }
}
