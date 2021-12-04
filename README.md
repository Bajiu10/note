# 起步
`Max-Blog` 基于 `Max-PHP`开发

# 环境要求

php > 8

如果可以的话，可以自行修改支持7.4

# 使用
下载压缩包，解压, 将.example.env文件修改为.env 

> 因为一些原因，必须开启redis

配置数据库`(mysql)`配置文件`/config/database.php`中的配置。
在项目目录运行`php max install` 根据提示安装。
`php max serve` 打开博客

# 常见问题

> Uncaught Error: Interface "Max\Swoole\Contracts\WebSocketControllerInterface" not found in C:\Users\ChengYao\Desktop\note\
   app\Http\Controllers\WebSocket\Chat.php:14

这个是因为现在去掉了Swoole相关的功能，如果开启注解路由会导致报错，所以关闭注解路由或者将Websocket控制器注解移除即可

> 提示***表不存在

使用 `php max install` 安装即可，不要重复安装，否则之前的数据会全部丢失。

> composer install 之后抛出FileNotFoundException， 请修改.env文件之后执行 `php max vendor:publish`