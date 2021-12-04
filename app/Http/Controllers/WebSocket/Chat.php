<?php

namespace App\Http\Controllers\WebSocket;

use Max\Di\Annotations\Inject;
use Max\Http\Request;
use Max\Redis\Redis;
use Max\Swoole\Contracts\WebSocketControllerInterface;
use Max\Swoole\Pool\Pools\Table;

/**
 * 这个要重构，等max/swoole重构后重写一遍
 */
class Chat
{
    protected array $bannedKeywords = [
        '习近平', '政治', '中国', '国家', '总理', '杀', '操', '草', '草泥马', '傻逼', '母狗' . '日' . '草', '艹', 'sb', 'porn',
    ];

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected Table $table;

    protected $session;

    /**
     * @param         $server
     * @param Request $request
     */
    public function open($server, $request)
    {
        $this->session = $request->cookie('PHP_SESSION_ID');
        if (!$this->table->exist($this->session)) {
            $this->table->set($this->session, ['id' => $request->fd]);
        }
    }

    public function message($server, $frame)
    {
        $id = $this->table->get($this->session, 'id');
        $data = str_ireplace($this->bannedKeywords, '*', htmlspecialchars(substr((string)$frame->data, 0, 200)));
        if ('init' === $data) {
            $len           = $this->redis->handle()->lLen('chat') ?? 0;
            $res['data']   = array_map(function($value) {
                return json_decode($value);
            }, $this->redis->handle()->lRange('chat', 0, min($len - 1, 19)));
            $res['online'] = count($server->connections);

            return json_encode($res);
        }
        $requestFd = $frame->fd;
        $data      = [
            'id'   => $id,
            'data' => $data,
            'time' => time(),
        ];
        $json      = json_encode(['data' => [$data]]);
        foreach ($server->connections as $fd) {
            if ($fd === $requestFd) {
                continue;
            }
            try {
                $server->push($fd, $json);
            } catch (\Throwable $throwable) {
            }
        }
        $this->redis->handle()->lPush('chat', json_encode($data));

        return $json;
    }

    public function close($server, $fd)
    {
    }
}
