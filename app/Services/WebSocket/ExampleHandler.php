<?php

namespace App\Services\WebSocket;

use Max\Server\Contracts\WebSocketHandlerInterface;
use Max\Server\WebSocket\Annotations\WebSocketHandler;
use Swoole\Http\Request;
use Swoole\Table;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

#[WebSocketHandler(path: '/')]
class ExampleHandler implements WebSocketHandlerInterface
{
    /**
     * @var Table
     */
    protected Table $table;

    public function __construct()
    {
        $table = new Table(1 << 10);
        $table->column('uid', Table::TYPE_INT);
        $table->create();
        $this->table = $table;
    }

    /**
     * @param Server  $server
     * @param Request $request
     */
    public function open(Server $server, Request $request)
    {
        if (isset($request->get['id'])) {
            $this->table->set($request->fd, ['uid' => $request->get['id']]);
        }
    }

    /**
     * @param Server $server
     * @param Frame  $frame
     */
    public function message(Server $server, Frame $frame)
    {
        $uid = $this->table->get($frame->fd, 'uid');
        $server->push($frame->fd, $uid);
    }

    /**
     * @param Server $server
     * @param        $fd
     */
    public function close(Server $server, $fd)
    {
        $this->table->del($fd);
    }
}
