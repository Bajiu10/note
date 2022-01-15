@extends('mt/layout/main')
@section('body')
    <main class="container" style="margin-top: 3.8em">
        <div class="left" style="width: 75%; margin-right: 1%">
            <div id="banner-content"
                 style="background: url('/static/bg/bg{{rand(1,31)}}.jpg'); ">
                <div>
                    <p class="big-font">MAX</p>
                    <p class="small-font">组件化的轻量PHP框架！</p>
                    <a id="recommend" href="https://docs.1kmb.com"><i
                                class="fa fa-book"></i>&nbsp;&nbsp;快速入门</a>
                    <p class="links" style="flex-wrap: wrap">
                        <span id="version">Loading... </span>
                        <a href="https://github.com/topyao/max" target="_blank" rel="noopener"> Github </a>
                        <a href="https://packagist.org/packages/max/max" target="_blank"
                           rel="noopener"> Packagist</a>
                    </p>
                </div>
                <div class="d-bg">
                    <i class="fa fa-thumbs-o-up" style="font-size: 10em; color: white;" aria-hidden="true"></i>
                </div>
            </div>
            <div class="par-card" style="margin-bottom: .5em">
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back"
                         style="background: white url('/static/img/packages/routing.png') no-repeat; background-size: cover">
                    </div>
                    <div class="sm-title">
                        <a href="https://github.com/topyao/max-routing">一款轻量的路由</a>
                    </div>
                </div>
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back"
                         style="background: white url('/static/img/packages/blade.png') no-repeat; background-size: cover">
                    </div>
                    <div class="sm-title">
                        <a href="https://github.com/topyao/max-view">Blade视图引擎</a>
                    </div>
                </div>
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back"
                         style="background: white url('/static/img/packages/maxgo.png') no-repeat; background-size: cover">
                    </div>
                    <div class="sm-title">
                        <a href="https://github.com/topyao/maxgo-skeleton">MaxGo</a>
                    </div>
                </div>
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back" style="background: linear-gradient(28deg, #320bff, #e5690ba1);">
                    </div>
                    <div class="sm-title">
                        分类
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="tips">最新发布</div>
                <div id="content">
                    @include('mt/layout/list')
                </div>
            </div>
            <ul class="paginate" style="text-align: center">
                <span id="get-more">
                    <i class="fa fa-circle" style="font-size: .9em; font-weight: bold; cursor: pointer">&nbsp;More</i>
                </span>
            </ul>
            <div class="card">
                <div class="tips" style="margin-bottom: .5em"><i class="fa fa-link"></i>&nbsp;&nbsp;Links</div>
                <div class="card-content">
                    @include('mt/layout/links')
                </div>
            </div>
        </div>
        <div class="d-bg" style="width: 24%">

            <style>
                p {
                    margin-top: 0;
                    margin-bottom: 1rem;
                }

                img {
                    vertical-align: middle;
                }

                ::-moz-focus-inner {
                    padding: 0;
                    border-style: none;
                }

                .d-flex {
                    display: flex !important;
                }

                .w-100 {
                    width: 100% !important;
                }

                .justify-content-between {
                    justify-content: space-between !important;
                }

                .widget-box {
                    box-shadow: rgb(240 240 240) 0 0 4px 0;
                    border-radius: 5px;
                }

                .widget-box {
                    padding: .5rem;
                }

                .widget-box .widget-box-title {
                    font-weight: 700;
                    letter-spacing: -0.025em;
                }

                .widget-box .comments-small-list .comments-small {
                    padding: .5rem;
                    margin-top: .5rem;
                    border-radius: .5rem;
                }

                .widget-box .comments-small-list .comments-small:hover {
                    background-color: #f5f5f5;
                }

                .widget-box .comments-small-list .comments-small .avatar {
                    border-radius: 8px;
                    width: 32px;
                    height: 32px;
                    margin-right: .75rem;
                }

                .comments-small-list .comments-small .content .comment-text {
                    font-size: .8rem;
                    color: black;
                    margin-bottom: .2rem;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                }

                .comments-small-list .comments-small .content .comment-author, .comments-small-list .comments-small .content .comment-date {
                    font-size: .65rem;
                    color: grey;
                    opacity: .75;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-line-clamp: 1;
                    -webkit-box-orient: vertical;
                    margin: 0;
                }
            </style>
            <div class="widget-box" id="news-comments">
                <div class="tips">最新评论</div>
                <div class="comments-small-list">
                    @foreach($comments as $comment)
                        <a class="comments-small d-flex"
                           href="/note/{{$comment['note_id']}}.html#comment-{{$comment['id']}}">
                            <img class="avatar lazyload"
                                 src="https://sdn.geekzu.org/avatar/7097810a7f79562ebe95ad5ad50b3c5a?d=mm"
                                 data-src="https://sdn.geekzu.org/avatar/7097810a7f79562ebe95ad5ad50b3c5a?d=mm">
                            <div class="content w-100">
                                <p class="comment-text">{{$comment['comment']}}</p>
                                <div class="d-flex justify-content-between"><p class="comment-author">
                                        @{{$comment['name']}}</p>
                                    <p class="comment-date">{{time_convert(strtotime($comment['create_time']))}}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{--            <div class="card" id="news-comments">--}}
            {{--                <div class="tips">最新评论</div>--}}
            {{--                <div id="comments" style="padding:0 .5em">--}}
            {{--                    <div style="margin: 1em 0 0;font-size: 14px;">--}}
            {{--                        <div style="display: flex;justify-content: space-between;line-height: 2em;height: 2em">--}}
            {{--                            <div><img src="/favicon.ico" alt="" style="width: 2em;height: 2em;border-radius: 50%"><b--}}
            {{--                                        style="position:absolute;font-size:14px;height: 2em;margin-left:.5em">--}}
            {{--                                    </b>--}}
            {{--                            </div>--}}
            {{--                            <span style="color:grey;font-size: 13px"></span>--}}
            {{--                        </div>--}}
            {{--                        <div style="padding:.5em 0 0 2.5em;word-break: break-all;word-wrap: break-word;color: #626262">--}}
            {{--                            <div>--}}
            {{--                                <div style="margin-bottom: .5em;display: flex;color: #626262">--}}
            {{--                                                                               </div>--}}
            {{--                            </div>--}}
            {{--                            --}}{{--                                <div style="font-size:.9em;text-align:right;padding:0 0 .3em;border-bottom: 1px solid #dbdbdb;color: grey">--}}
            {{--                            --}}{{--                                    <i class="fa--}}
            {{--                            --}}{{--                                                                                    fa-heart--}}
            {{--                            --}}{{--                                 like" data-id="5" style="color: red;cursor:pointer;"></i> <span--}}
            {{--                            --}}{{--                                            class="count-heart">1</span>--}}
            {{--                            --}}{{--                                    <i class="fa fa-comment-o" style="margin-left: 1em"></i>--}}
            {{--                            --}}{{--                                   <span class="review">回复</span>--}}
            {{--                            --}}{{--                                </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="card" id="recommend-notes" style="box-sizing: border-box;">
                <div class="tips">推荐</div>
                <ul class="card-content">
                    @foreach($hots as $hot)
                        <li>
                            <a href="/note/{{$hot['id']}}.html">{{$hot['title']}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </main>
@endsection
@section('js')
    <script>
        document.onscroll = function () {
            let catalog = document.getElementById('recommend-notes');
            if (document.documentElement.scrollTop > 400) {
                catalog.style.position = 'fixed';
                catalog.style.top = '3.5em';
            } else {
                catalog.style.position = 'relative';
                catalog.style.top = 'inherit';
            }
            $('#recommend-notes').css('width', $('#news-comments')[0].offsetWidth);
        }


        $(function () {
            let page = 1;

            $.get('https://api.github.com/repos/topyao/max/tags', function (data, status) {
                if ('success' === status) {
                    if (undefined !== data[0]) {
                        $('span#version').text(data[0].name);
                    }
                }
            })

            $('.friendlink').each(function (id, el) {
                el.onclick = function () {
                    let id = el.getAttribute('data-id');
                    $.ajax({
                        url: '/links/' + id,
                        type: 'get',
                        dataType: 'json',
                        success: function (e) {

                        }
                    })
                }
            })

            $('#get-more').on('click', function () {
                page++;
                $.ajax({
                    url: '/api/notes?p=' + page,
                    type: 'GET',
                    dataType: 'json',
                    success: function (e) {
                        if (e.length < 8) {
                            $('.paginate').remove();
                        }
                        for (i in e) {
                            time_convert(e[i]['create_time']);
                            var lock = '0' === e[i]['permission'] ? '' : '<i class="fa fa-lock" aria-hidden="true"></i> ';
                            var html = `<div class="list-item"><div><a target="_blank" href="/note/${e[i]['id']}.html"><img id="thumb" src="${e[i]['thumb']}" alt=""></a></div><div class="list-content"><div><div class="list-content-title"><a target="_blank" class="article-title" href="/note/${e[i]['id']}.html">${lock + e[i]['title']}</a></div><div class="description">${e[i]['abstract']}</div></div><div class="list-content-bottom"><span><i class="fa fa-calendar"></i>&nbsp;&nbsp;${time_convert(e[i]['create_time'])}&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-folder"></i>&nbsp;&nbsp;${e[i]['type']}</span><span> <i class="fa fa-eye"></i>&nbsp;${e[i]['hits']}&nbsp;&nbsp;<a target="_blank" style="margin-left: .5em;color: #309bee" href="/note/${e[i]['id']}.html"><i class="fa fa-book"></i>&nbsp;&nbsp;继续阅读</a></span></div></div></div>`;
                            $(html).appendTo('#content');
                        }
                    }
                })
            })

        })


    </script>
@endsection
