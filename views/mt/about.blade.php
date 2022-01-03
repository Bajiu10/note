@extends('mt/layout/main')
@section('title')
    关于 | MaxPHP - 基于组件的轻量PHP框架！
@endsection
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center; background-size: cover">
        <h1 style="color: white; font-weight: bold">About</h1>
    </div>
    <main id="app" style="margin-top: .8em">
        <div style="display: flex;justify-content: space-around">
            <p style="width: 30%;text-align: center;font-weight: bolder;color: grey;font-size:1.5em">访问量：<span
                        style="color: #4F70F6">{{number_format($stat)}}</span></p>
            <p id="down" style="width: 30%;text-align: center;font-weight: bolder;color: grey;font-size:1.5em">
                Loading... </p>
        </div>
        <p style="text-align: center;font-weight: bold;color:grey;margin: 0 0 1.5em"><i class="fa fa-link"></i> &nbsp;&nbsp;起步
        </p>
        <div id="step1" style="display: flex;justify-content: space-between;">
            <div class="card advantages" style="width:100%;margin-right: .5em">
                <div class="tips">特性</div>
                <div style="margin:.5em;color:#2d2626;line-height: 1.1em;text-align: left;font-size: 1.1em;padding:.5em;font-weight: bold">
                    <code>
                        一、&nbsp;组件和框架核心分离<br>
                        二、&nbsp;基于 Psr7 的 HTTP-Message<br>
                        三、&nbsp;基于 Psr11 的容器，支持接口注入[支持注解 PHP8.0]<br>
                        四、&nbsp;友好的 IDE 自动完成<br>
                        五、&nbsp;支持门面<br>
                        六、&nbsp;方便的数据库操作方法，支持 MySQL、PostgreSQL 等[可扩展]<br>
                        七、&nbsp;基于 Psr14 的事件[支持注解 PHP8.0]<br>
                        八、&nbsp;基于 Psr15 的中间件[支持注解 PHP8.0]<br>
                        九、&nbsp;支持路由功能[支持注解 PHP8.0]<br>
                        十、&nbsp;基于 Psr16 的缓存组件,支持 File,Memcached,Redis,APC[可扩展]<br>
                        十、&nbsp;支持 Blade 的可扩展驱<br>
                        十、&nbsp;简单易用的命令行操作<br>
                        十、&nbsp;命令行，验证器，trace<br>
                    </code>
                </div>
            </div>
            <div style="width:100%" class="card">
                <div class="tips">安装要求</div>
                <div style="margin:.5em;color:#2d2626;line-height: 1.1em;text-align: left;font-size: 1.1em;padding:.5em;font-weight: bold">
                    <code>PHP >= 7.4 √</code>
                </div>
                <div class="tips">使用Composer安装</div>
                <div style="margin:.5em;color:#2d2626;line-height: 1.1em;text-align: left;font-size: 1.1em;padding:.5em;font-weight: bold">
                    <code>composer create-project --prefer-dist max/max .</code>
                </div>
                <div class="tips">
                    运行框架
                </div>
                <div style="margin:.5em;color:#2d2626;line-height: 1.1em;text-align: left;font-size: 1.1em;padding:.5em;font-weight: bold">
                    <code>php max serve</code><br>
                </div>
            </div>
        </div>
        <p style="text-align: center;font-weight: bold;color:grey;margin: 1.5em 0;"><i
                    class="fa fa-link"></i> &nbsp;&nbsp;开发团队</p>
        <div class="team">
            <div class="users">
                <a href="#"><img class="users" alt="undetermined"
                                 src="/favicon.ico"></a>
                <p>undetermined</p>
            </div>
            <div class="users">
                <a href="https://github.com/topyao"><img class="users" alt="chengyao"
                                                         src="https://avatars.githubusercontent.com/u/64066545?s=400&u=319aa25dbecffeba5b52fdb8449cf411f75ce3f2&v=4"></a>
                <p>chengyao</p>
            </div>
            <div class="users">
                <a href=""><img class="users" alt="chengyao" src="/favicon.ico"></a>
                <p>undetermined</p>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
        $(() => {
            $.get('https://api.github.com/repos/topyao/max/tags', function (data, status) {
                if ('success' === status) {
                    $('#download').html('<i class="fa fa-download"></i> 立即下载').attr('href', data[0].zipball_url);
                    $('span#version').text(data[0].name);
                }
            })
            $.get('https://packagist.org/packages/max/max.json', function (data, status) {
                if ('success' === status) {
                    $('#down').html('下载次数：<span style="color: #4F70F6">' + data.package.downloads.total + '</span>');
                }
            });
        })
    </script>
@endsection
{!!adsds !!}
