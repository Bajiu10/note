# 起步
`Max-Blog` 基于 `Max-PHP + swoole`开发

# 环境要求

PHP >= 8.0
Swoole >= 4.7


# 使用
下载压缩包，解压, 将.example.env文件修改为.env

> 因为一些原因，必须开启redis

配置数据库`(mysql)`配置文件`/config/database.php`中的配置。
在项目目录运行`php max install` 根据提示安装。
`php max serve` 打开博客

# 常见问题

> 提示***表不存在

使用 `php max install` 安装即可，不要重复安装，否则之前的数据会全部丢失。

> composer install 之后抛出FileNotFoundException， 请修改.env文件之后执行 `php max vendor:publish`
