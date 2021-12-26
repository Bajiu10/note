<?php


namespace App\Http\Middleware\Common;

use Max\Foundation\Facades\Cache;
use Max\Foundation\Facades\DB;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Statistic implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        DB::table('stats')->insert([
            'ip' => $request->ip(),
            'referrer' => $request->header('referer'),
            'path' => $request->url(true),
        ]);
        try {
            $stat = (int)Cache::get('stat');
            Cache::set('stat', ++$stat);
        } catch (\Exception $e) {
        }
        return $handler->handle($request);
    }
}
