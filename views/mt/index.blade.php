@extends('mt/layout/main')
@section('body')
    <div id="banner-content"
         style="background: url('/static/bg/bg{{rand(1, 10)}}.jpg') no-repeat center center; margin-bottom: 1em;">
        <div>
            <p class="big-font">MAX</p>
            <p class="small-font">基于组件的轻量PHP框架！</p>
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
    <main class="container">
        <div class="left" style="width: 75%; margin-right: 1%">
            <div class="par-card" style="margin-bottom: .5em">
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back" style="background: white url('/static/bg/bg{{rand(1, 10)}}.jpg') no-repeat;">
                    </div>
                    <div class="sm-title">
                        分类
                    </div>
                </div>
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back" style="background: white url('/static/bg/bg{{rand(1, 10)}}.jpg') no-repeat;">
                    </div>
                    <div class="sm-title">
                        分类
                    </div>
                </div>
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back" style="background: white url('/static/bg/bg{{rand(1, 10)}}.jpg') no-repeat;">
                    </div>
                    <div class="sm-title">
                        分类
                    </div>
                </div>
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back" style="background: white url('/static/bg/bg{{rand(1, 10)}}.jpg') no-repeat;">
                    </div>
                    <div class="sm-title">
                        分类
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="tips">最新发布</div>
                <div id="content">
                    @foreach($notes as $note)
                        <div class="list-item">
                            <div>
                                <a href="{{url('read',[$note['id']])}}"><img id="thumb"
                                                                             data-original="{{$note['thumb']}}"
                                                                             alt=""></a>
                            </div>
                            <div class="list-content">
                                <div>
                                    <div class="list-content-title">
                                        <a class="article-title"
                                           href="{{url('read',[$note['id']])}}">{{$note['title']}}</a>
                                    </div>
                                    <div class="description">
                                        {{$note['abstract']}}
                                    </div>
                                </div>
                                <div class="list-content-bottom">
                            <span><i class="fa fa-calendar"></i>&nbsp;&nbsp;{{time_convert($note['create_time'])}}&nbsp;&nbsp;&nbsp;&nbsp;<i
                                        class="fa fa-folder"></i>&nbsp;&nbsp;{{$note['type']}}</span>
                                    <span> <i class="fa fa-eye"></i>&nbsp;{{$note['hits']}}&nbsp;&nbsp;<a
                                                style="margin-left: .5em;color: #309bee"
                                                href="{{url('read',[$note['id']])}}"><i
                                                    class="fa fa-book"></i>&nbsp;&nbsp;继续阅读</a></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
            <div class="card" id="news-comments">
                <div class="tips">最新评论</div>
                @foreach($comments as $comment)
                    <div id="comments" style="padding:0 .5em">
                        <div style="margin: 1em 0 0;font-size: 14px;">
                            <div style="display: flex;justify-content: space-between;line-height: 2em;height: 2em">
                                <div><img src="/favicon.ico" alt="" style="width: 2em;height: 2em;border-radius: 50%"><b
                                            style="position:absolute;font-size:14px;height: 2em;margin-left:.5em">
                                        {{$comment['name']}}</b>
                                </div>
                                <span style="color:grey;font-size: 13px">{{time_convert(strtotime($comment['create_time']))}}</span>
                            </div>
                            <div style="padding:.5em 0 0 2.5em;word-break: break-all;word-wrap: break-word;color: #626262">
                                <div>
                                    <div style="margin-bottom: .5em;display: flex;color: #626262">
                                        {{$comment['comment']}}                                            </div>
                                </div>
                                {{--                                <div style="font-size:.9em;text-align:right;padding:0 0 .3em;border-bottom: 1px solid #dbdbdb;color: grey">--}}
                                {{--                                    <i class="fa--}}
                                {{--                                                                                    fa-heart--}}
                                {{--                                 like" data-id="5" style="color: red;cursor:pointer;"></i> <span--}}
                                {{--                                            class="count-heart">1</span>--}}
                                {{--                                    <i class="fa fa-comment-o" style="margin-left: 1em"></i>--}}
                                {{--                                   <span class="review">回复</span>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card" id="recommend-notes" style="box-sizing: border-box;">
                <div class="tips">推荐</div>
                <ul class="card-content">
                    @foreach($hots as $hot)
                        <li>
                            <a href="{{url('read',[$hot['id']])}}">{{$hot['title']}}</a>
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
            if (document.documentElement.scrollTop > 830) {
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
                    url: '/api/notes/list?p=' + page,
                    type: 'GET',
                    dataType: 'json',
                    success: function (e) {
                        if (e.length < 8) {
                            $('.paginate').remove();
                        }
                        for (i in e) {
                            time_convert(e[i]['create_time']);
                            var html = `<div class="list-item"><div><a href="/note/${e[i]['id']}.html"><img id="thumb" src="${e[i]['thumb']}" alt=""></a></div><div class="list-content"><div><div class="list-content-title"><a class="article-title" href="/note/${e[i]['id']}.html">${e[i]['title']}</a></div><div class="description">${e[i]['abstract']}</div></div><div class="list-content-bottom"><span><i class="fa fa-calendar"></i>&nbsp;&nbsp;${time_convert(e[i]['create_time'])}&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-folder"></i>&nbsp;&nbsp;${e[i]['type']}</span><span> <i class="fa fa-eye"></i>&nbsp;${e[i]['hits']}&nbsp;&nbsp;<a style="margin-left: .5em;color: #309bee" href="/note/${e[i]['id']}.html"><i class="fa fa-book"></i>&nbsp;&nbsp;继续阅读</a></span></div></div></div>`;
                            $(html).appendTo('#content');
                        }
                    }
                })
            })

        })


    </script>
@endsection
