<?php

namespace App\Services\WebSocket;

use App\Lib\Jwt;
use App\Model\Entities\User;
use Max\Database\Redis;
use Max\Di\Annotations\Inject;
use Max\Log\LoggerFactory;
use Max\Server\Contracts\WebSocketHandlerInterface;
use Max\Server\WebSocket\Annotations\WebSocketHandler;
use Max\Utils\Collection;
use Swoole\Http\Request;
use Swoole\Table;
use Swoole\Timer;
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

    #[Inject]
    protected Jwt $jwt;

    #[Inject]
    protected LoggerFactory $loggerFactory;

    protected int $length = 20;

    protected const OPCODE_USER_MESSAGE = 100;
    protected const OPCODE_HISTORY_MESSAGES = 101;

    protected const KEY = 'maxphp:chatroom:msg';

    public function __construct()
    {
        $table = new Table(1 << 10);
        $table->column('uid', Table::TYPE_INT);
        $table->create();
        $this->table = $table;
//        Timer::tick(10000, function() {
//            $count = 1;
//            while ($count < $this->length && $this->redis->lLen(self::KEY) > $this->length) {
//                $count++;
//                $message = $this->redis->lPop(self::KEY);
//                try {
//                    $data = json_decode($message, true);
//                    \App\Model\Entities\Message::create([
//                        'user_id'    => $data['uid'],
//                        'text'       => $data['data'],
//                        'created_at' => date('Y-m-d H:i:s', $data['time'])
//                    ]);
//                } catch (\Exception $exception) {
//                    $this->loggerFactory->get()->error($exception->getMessage());
//                    $this->redis->lPush($message);
//                }
//            }
//        });
    }

    /**
     * @param Server $server
     * @param Request $request
     */
    public function open(Server $server, Request $request)
    {
        if (isset($request->get['token']) && $request->get['token']) {
            $user = $this->jwt->decode($request->get['token']);
            $this->table->set($request->fd, ['uid' => $user?->id]);
        } else {
            $this->table->set($request->fd, ['uid' => 0]);
        }
        $len = $this->redis->lLen(self::KEY);
        $data = $this->redis->lRange(self::KEY, max(0, $len - $this->length), $len);
        $ids = [];
        foreach ($data as &$v) {
            $v = json_decode($v, true);
            $v['data'] = htmlspecialchars($v['data']);
            if (!in_array($v['uid'], $ids)) {
                $ids[] = $v['uid'];
            }
        }
        /** @var Collection $users */
        $users = User::whereIn('id', $ids)->get()->keyBy('id');
        foreach ($data as &$v) {
            if ($users->has($v['uid'])) {
                $v['avatar'] = $users->get($v['uid'])->avatar;
            } else {
                $v['avatar'] = 'https://cdn.shopify.com/s/files/1/1493/7144/products/product-image-16756312_1024x1024.jpg?v=1476865937';
            }
        }
        $server->push($request->fd, json_encode([
            'code' => self::OPCODE_HISTORY_MESSAGES,
            'data' => $data,
        ]));
    }

    /**
     * @param Server $server
     * @param Frame $frame
     */
    public function message(Server $server, Frame $frame)
    {
        if ($frame->data === 'ping') {
            $server->push($frame->fd, json_encode(['code' => 0, 'online' => $this->table->count()]));
        } else {
            if (($uid = $this->table->get($frame->fd, 'uid')) || !($user = User::find($uid))) {
                $user = new User(['id' => 0, 'username' => '匿名用户', 'avatar' => 'https://cdn.shopify.com/s/files/1/1493/7144/products/product-image-16756312_1024x1024.jpg?v=1476865937']);
            }
            $data = ['uid' => $uid, 'username' => $user->username, 'avatar' => $user->avatar, 'data' => $frame->data, 'time' => time()];
            $this->redis->rPush(self::KEY, json_encode($data));
            $data['data'] = htmlspecialchars($data['data']);
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
