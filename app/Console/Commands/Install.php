<?php

namespace App\Console\Commands;

use Max\Console\Command;
use Max\Foundation\Facades\DB;

/**
 * Class Install
 * @package App\Console\Commands
 */
class Install extends Command
{
    /**
     * @var string
     */
    protected string $lock = './install.lock';

    /**
     * @var string[]
     */
    protected $userinfo = [
        'username' => '',
        'password' => '',
        'email'    => '',
    ];

    /**
     * @throws \Exception
     */
    public function handle()
    {
        if (file_exists($this->lock)) {
            echo '已经安装过，请先删除install.lock: ', $this->lock, "\n";
            exit;
        }
        $this->createTable();
        echo "输入用户名：";
        $this->getString($this->userinfo['username']);
        echo "输入密码: ";
        $this->getString($this->userinfo['password']);
        $this->userinfo['password'] = md5($this->userinfo['password']);
        echo "输入邮箱: ";
        $this->getString($this->userinfo['email']);
        DB::table('users')->insert($this->userinfo);
        touch($this->lock);
        echo "安装成功！输入php max serve 快速体验！ \n";
    }


    /**
     * @param $variable
     */
    public function getString(&$variable)
    {
        fscanf(STDIN, '%s', $variable);
    }

    /**
     * @param $table
     */
    public function drop($table)
    {
        DB::exec("DROP TABLE IF EXISTS {$table}");
    }

    /**
     * @param $str
     * @return string
     */
    protected function quote($str)
    {
        $type = $this->app->config->get('database.default');
        switch ($type) {
            case 'pgsql':
                $delimiter = '\'';
                break;
            case 'mysql':
                $delimiter = '`';
                break;
            default:
                $delimiter = '';
        }
        return "{$delimiter}{$str}{$delimiter}";
    }

    /**
     * @throws \Exception
     */
    public function createTable()
    {
        $table = <<<TABLE
CREATE TABLE `notes` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hits` mediumint NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `tags` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `user_id` int NOT NULL DEFAULT '0' COMMENT '用户id',
  `thumb` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sort` tinyint,
  `cid` mediumint DEFAULT '1',
  `permission` tinyint not null default 0 comment '权限0公开，1仅自己',
  FULLTEXT KEY `ft_text` (text`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC
TABLE;
        try {
            $this->drop('notes');
            DB::exec($table);
        } catch (\Exception $e) {
            throw new \Exception('创建笔记表失败!' . $e->getMessage());
        }
        $table = <<<TABLE
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note_id` int NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
TABLE;
        try {
            $this->drop('comments');
            DB::exec($table);
        } catch (\Exception $e) {
            throw new \Exception('创建评论表失败!' . $e->getMessage());
        }
        $table = <<<TABLE
CREATE TABLE IF NOT EXISTS `categories` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` mediumint NOT NULL DEFAULT '0' COMMENT '父级ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
TABLE;
        try {
            $this->drop('categories');
            DB::exec($table);
        } catch (\Exception $e) {
            throw new \Exception('创建评论表失败!' . $e->getMessage());
        }
        $table = <<<TABLE
 CREATE TABLE IF NOT EXISTS `hearts` (
  `comment_id` int NOT NULL DEFAULT '0',
  `user_id` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
TABLE;
        try {
            $this->drop('hearts');
            DB::exec($table);
        } catch (\Exception $e) {
            throw new \Exception('创建喜欢表失败!' . $e->getMessage());
        }
        $table = <<<TABLE
CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL default '',
  `sex` tinyint NOT NULL DEFAULT '0' COMMENT '0 未知；1 女； -1 男',
  `phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT '',
  `age` tinyint DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_time` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC
TABLE;
        try {
            $this->drop('users');
            DB::exec($table);
        } catch (\Exception $e) {
            throw new \Exception('创建用户表失败!' . $e->getMessage());
        }
        $table = <<<TABLE
CREATE TABLE `links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `hits` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4
TABLE;
        try {
            $this->drop('links');
            DB::exec($table);
        } catch (\Exception $e) {
            throw new \Exception('创建链接表失败!' . $e->getMessage());
        }
    }

}
