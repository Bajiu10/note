<?php

namespace App\Services\WebSocket;

use Max\Database\Redis;
use Max\Di\Annotations\Inject;
use Max\Server\Contracts\WebSocketHandlerInterface;
use Max\Server\WebSocket\Annotations\WebSocketHandler;
use Swoole\Http\Request;
use Swoole\Table;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

#[WebSocketHandler(path: '/')]
class ChatRoomHandler implements WebSocketHandlerInterface
{
    /**
     * @var Table
     */
    protected Table $table;

    #[Inject]
    protected Redis $redis;

    protected const OPCODE_USER_MESSAGE     = 100;
    protected const OPCODE_HISTORY_MESSAGES = 101;

    protected const KEY = 'maxphp:chatroom:msg';

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
        $len  = $this->redis->lLen(self::KEY);
        $data = $this->redis->lRange(self::KEY, max(0, $len - 10), $len);
        foreach ($data as &$v) {
            $v = json_decode($v, true);
        }
        $server->push($request->fd, json_encode([
            'code' => self::OPCODE_HISTORY_MESSAGES,
            'data' => $data,
        ]));
    }

    /**
     * @param Server $server
     * @param Frame  $frame
     */
    public function message(Server $server, Frame $frame)
    {
        if ($frame->data === 'ping') {
            $server->push($frame->fd, 'pong');
        } else {
            $uid  = $this->table->get($frame->fd, 'uid');
            $data = ['uid' => $uid, 'data' => $frame->data];
            $this->redis->rPush(self::KEY, json_encode($data));
            foreach ($server->connections as $fd) {
                $server->push($fd, json_encode([
                    'code' => self::OPCODE_USER_MESSAGE,
                    'data' => $data,
                ]));
            }
        }
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
