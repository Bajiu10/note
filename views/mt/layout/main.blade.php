<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MaxPHP - 组件化的轻量PHP框架！')</title>
    <meta name="keywords" content="MaxPHP,PHP框架,MVC框架">
    <link rel="stylesheet" href="/static/css/css.css?20210767">
    <link rel="stylesheet" href="/static/css/loading.css">
    <link href="/static/css/font-awesome.css" rel="stylesheet">
    @yield('head')
</head>
<body>
<div id="PageLoading" style="z-index: 999999; ">
    <div id="PageLoading-center">
        <div id="PageLoading-center-absolute">
            <div class="object" id="object_four"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_one"></div>
        </div>
    </div>
</div>
<div>
    <header>
        <nav>
            <ul class="bg-nav">
                <li class="left-items"><a href="/">主页</a></li>
                <li class="left-items d-bg"><a href="javascript: void(0)">数据库&nbsp;&nbsp;<i class="fa fa-angle-down"
                                                                                            aria-hidden="true"></i></a>
                    <ul class="dropdown-menu-box">
                        <div class="cat-box">
                            <a class="item" href="/search?kw=MySQL">
                                <div class="content">
                                    <img src="https://tse3-mm.cn.bing.net/th/id/OIP-C.FEvZIQaiXEQmH1Hv-36PYQHaEo?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>MySQL</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=PgSQL">
                                <div class="content">
                                    <img src="https://tse1-mm.cn.bing.net/th/id/OIP-C.mULv-hbU_ifsh9Z4TqDsUwHaE7?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>PgSQL</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Oracle">
                                <div class="content">
                                    <img src="https://tse4-mm.cn.bing.net/th/id/OIP-C.V2uKMtc5Af1AbZVXngOEigHaHa?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Oracle</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Redis">
                                <div class="content">
                                    <img src="https://tse2-mm.cn.bing.net/th/id/OIP-C.4aUnpyNSaSYPrAJGLcjQhgAAAA?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Redis</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=MongoDB">
                                <div class="content">
                                    <img src="https://tse3-mm.cn.bing.net/th/id/OIP-C.kRURuX0Lf2PFNEHcCSA1dQHaDv?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>MongoDB</div>
                                </div>
                            </a>
                        </div>
                    </ul>
                </li>
                <li class="left-items d-bg"><a href="javascript: void(0)">前端&nbsp;&nbsp;<i class="fa fa-angle-down"
                                                                                           aria-hidden="true"></i></a>
                    <ul class="dropdown-menu-box">
                        <div class="cat-box">
                            <a class="item" href="/search?kw=JavaScript">
                                <div class="content">
                                    <img src="https://tse4-mm.cn.bing.net/th/id/OIP-C.HSTrtsTHh2QhAQGbQLO38wHaHa?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>JavaScript</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=JQuery">
                                <div class="content">
                                    <img src="https://tse1-mm.cn.bing.net/th/id/OIP-C.WSggs9c4OpdiWDEm7V-edwAAAA?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>JQuery</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Vue">
                                <div class="content">
                                    <img src="https://tse1-mm.cn.bing.net/th/id/OIP-C.-2RieYNX0he-cV5XrBf2DQHaD4?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Vue</div>
                                </div>
                            </a>
                        </div>
                    </ul>
                </li>
                <li class="left-items d-bg"><a href="javascript: void(0)">后端&nbsp;&nbsp;<i class="fa fa-angle-down"
                                                                                           aria-hidden="true"></i></a>
                    <ul class="dropdown-menu-box">
                        <div class="cat-box">
                            <a class="item" href="/search?kw=Linux">
                                <div class="content">
                                    <img src="https://tse1-mm.cn.bing.net/th/id/OIP-C.6aYY2mMI8zSiTYinsMqc_gHaDt?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Linux</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=PHP">
                                <div class="content">
                                    <img src="https://tse2-mm.cn.bing.net/th/id/OIP-C.3cKadU-tUTal8TQ7Z59N_wAAAA?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>PHP</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Go">
                                <div class="content">
                                    <img src="https://tse4-mm.cn.bing.net/th/id/OIP-C.XjGcvPxFnflel7epuQ6OJwHaHa?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Go</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Shell">
                                <div class="content">
                                    <img src="https://tse2-mm.cn.bing.net/th/id/OIP-C.LqeIOTm2kjG5xqbP2PIvNgHaC-?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Shell</div>
                                </div>
                            </a>
                        </div>
                    </ul>
                </li>
                <li class="left-items d-bg"><a href="javascript: void(0)">软件&nbsp;&nbsp;<i class="fa fa-angle-down"
                                                                                           aria-hidden="true"></i></a>
                    <ul class="dropdown-menu-box">
                        <div class="cat-box">
                            <a class="item" href="/search?kw=Docker">
                                <div class="content">
                                    <img src="https://tse2-mm.cn.bing.net/th/id/OIP-C.IQPERZi0pkVNPfblez0UFQHaGV?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Docker</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=PHPStorm">
                                <div class="content">
                                    <img src="https://tse3-mm.cn.bing.net/th/id/OIP-C.UPqJNaj5CrnixWpBMN3IsgHaHa?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>PHPStorm</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Vscode">
                                <div class="content">
                                    <img src="https://tse3-mm.cn.bing.net/th/id/OIP-C.Zq8hf7slzrS8BTH5j_4QiQAAAA?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Vscode</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Nginx">
                                <div class="content">
                                    <img src="https://tse4-mm.cn.bing.net/th/id/OIP-C.qD_aGR1dX3Db-2uciVVPfgHaFF?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Nginx</div>
                                </div>
                            </a>
                            <a class="item" href="/search?kw=Apache">
                                <div class="content">
                                    <img src="https://tse1-mm.cn.bing.net/th/id/OIP-C.5YTZlQb3WWsovlHwpdj7aAHaE8?pid=ImgDet&w=60&h=60&c=7&dpr=1.25"
                                         alt="">
                                    <div>Apache</div>
                                </div>
                            </a>
                        </div>
                    </ul>
                </li>
            </ul>
            <ul style="display: flex;justify-content: flex-end">
                <li class="d-bg">
                    <form action="/search">
                        <input required autocomplete="off" placeholder="太低调，百度搜不到" type="text" name="kw"
                               value="@isset($keyword){{$keyword}}@endisset"/>
                    </form>
                </li>
                <li>
                    <a href="https://docs.1kmb.com"><i
                                class="fa fa-book"></i> 文档</a>
                </li>
                <li class="d-bg"><a href="/about">关于</a></li>
                @if(!is_null(session('user.id')))
                    <li class="d-bg"><a title="发布" href="/notes/add"><i class="fa fa-pencil"></i></a></li>
                @endif
                <li class="d-sm dropdown-btn">
                    <a href="javascript:void(0)" id="dropdown"><i class="fa fa-bars"></i></a>
                </li>
                @if(!is_null(session('user.id')))
                    <li class="d-bg" style="min-width:2.5em">
                        <a href="/logout?from={{get_url()}}" title="退出"><i
                                    class="fa fa-sign-out"></i></a>
                    </li>
                @else
                    <li class="d-bg" style="min-width:2.5em">
                        <a href="/login?from={{get_url()}}" title="登录"><i
                                    class="fa fa-sign-in"></i></a>
                    </li>
                @endif
            </ul>
        </nav>
        <form action="/search">
            <ul id="phone-nav" style="display: none">
                <li><a href="/about">关于</a></li>
                @if(!is_null(session('user.id')))
                    <li><a href="/notes/add">发布</a></li>
                    <li><a href="/logout?from={{get_url()}}">退出</a></li>
                @else
                    <li><a href="/login?from={{get_url()}}">登录</a></li>
                @endif
                <li>
                    <input style="width:100%;height: 2.5em;outline: none;border-radius: 5px;border: none;background-color: #eeeeee;padding:0 .7em;box-sizing: border-box"
                           type="text" placeholder="太低调，百度搜不到" value="@isset($keyword){{$keyword}}@endif" name="kw">
                </li>
            </ul>
        </form>
    </header>
    @yield('body')
    <footer>
        <div id="footer-main">
            <div style="height: 80%">
                <h2>联系方式</h2>
                <p><a aria-label="QQ" href="http://wpa.qq.com/msgrd?v=3&uin=987861463&site=qq&menu=yes"><i
                                class="fa fa-qq" aria-hidden="true"></i> 987861463</a></p>
                <p><a title="QQ群" aria-label="QQ群"
                      href="https://qm.qq.com/cgi-bin/qm/qr?k=I5hM1g5EWFKhAndMyNFZrKREP8x4vf2X&jump_from=webapi"><i
                                class="fa fa-users" aria-hidden="true"></i> 542564341</a></p>
            </div>
            <div style="height: 80%">
                <h2>相关作品</h2>
                <p><a href="//github.com/topyao/note">MaxNote</a></p>
            </div>
            <div style="height: 80%">
                <h2>关于</h2>
                <p><a href="//github.com/topyao/max">使用Max/Swoole框架开发</a></p>
                <p>感谢 <a href="//www.jetbrains.com/?from=topyao">Phpstorm</a></p>
                <p><a href="//beian.miit.gov.cn" target="_blank" class="text">陕ICP备20000693号-2</a></p>
            </div>
        </div>
    </footer>
</div>
<script src="/static/js/jquery-3.5.1.js"></script>
<script src="/static/js/lazyload.js"></script>
<script src="/static/js/custom.js"></script>
<script>
    $(function () {
        $("#PageLoading").fadeOut(530);
        $("img").lazyload({effect: "fadeIn"});
        $('.dropdown-btn').on('click', function () {
            let dropdown = $('#dropdown');
            let nav = $('#phone-nav');
            if (dropdown.children('i').hasClass('fa-bars')) {
                nav.slideDown();
                dropdown.html('<i class="fa fa-close"></i>')
            } else {
                nav.slideUp();
                dropdown.html('<i class="fa fa-bars"></i>')
            }
        });

        $(".left-items").hover(function () {
            //stop是当执行其他动画的时候停止当前的
            $(this).children('ul').stop().slideDown()
        }, function () {
            $(this).children('ul').hide();
        });

        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?da5d43badbfffca5860bc60a1348ebfd";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    });
</script>
@include('mt/layout/chat')
</body>
@yield('js')
</html>
