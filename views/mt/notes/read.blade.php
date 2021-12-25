@extends('mt/layout/main')
@section('title')
    {!! $note['title'] !!} | MaxPHP - 基于组件的轻量PHP框架
@endsection

@section('head')
    <meta name="description" content="{!! $note['abstract'] !!}">
    <link rel="stylesheet" href="/static/editor/css/editormd.preview.css"/>
@endsection

@section('body')
    <div style="height:20em;background: url(
    @if(empty($note['thumb']))
            '/static/bg/bg{{rand(1, 33)}}.jpg'
    @else
            '{{$note['thumb']}}'
    @endif
            ) no-repeat center center; background-size: cover">
        <div style="width: 100%; height: 100%; backdrop-filter: saturate(180%) blur(20px); display: flex;justify-content: center; align-items: center; ">
            <div style="max-width: 90%">
                <p id="headline">{!! $note['title'] !!}</p>
                <p style="text-align: center;font-size: .9em;margin: 0;color: white"><i
                            class="fa fa-clock-o"></i>&nbsp;{{time_convert($note['create_time'])}}&nbsp;&nbsp;
                    <i class="fa fa-user"></i>&nbsp;Yao&nbsp;&nbsp;<i
                            class="fa fa-folder"></i>&nbsp;{{$note['category']}}&nbsp;&nbsp;<i
                            class="fa fa-eye"></i>&nbsp;{{$note['hits']}}&nbsp;&nbsp;<i
                            class="fa fa-comment"></i>&nbsp;{{$comments_count}}
                    @if(\Max\Foundation\Facades\Session::get('user.id') == $note['user_id'])
                        <a href="/notes/edit/{{$note['id']}}">&nbsp;&nbsp;<i style="color: white"
                                                                             class="fa fa-edit"></i></a>
                        <a id="delete" href="javascript:void(0)">&nbsp;&nbsp;<i style="color: red"
                                                                                class="fa fa-remove"></i></a>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <main style="margin-top: .5em">

        <div class="container">
            <div class="left" style="width:80%;">
                <div class="card" style="position: relative">
                    <div class="tips" style="margin-bottom: .5em"><i class="fa fa-bars"></i>&nbsp;&nbsp;<a
                                href="/">首页</a> /
                        {!! $note['title'] !!}
                    </div>
                    <i id="qrcode-btn"
                       style="cursor:pointer; font-size:1.5em; position: absolute; top: .2em; right: .3em;"
                       class="fa fa-qrcode"></i>
                    <div id="content-loading" style="text-align: center">
                        <span style="font-size: .9em">Loading...</span>
                    </div>
                    <div id="test-editormd-view2">
                        <textarea id="append-test" style="display: none">{!! $note['text'] !!}</textarea>
                    </div>
                    <span style="color:#cecdcd;display: block;text-align: center;font-size: .85em; user-select: none"
                          id="end"><b>THE END</b></span>
                    <div style="display:flex;justify-content: space-between;padding: .5em;font-size: .9em;color: grey">
                        <div>
                            上次更新：{{time_convert($note['update_time'])}}
                        </div>
                        <div>
                            @if(!empty($note['tags']))
                                <div style="height: 1.7em;">
                                    @foreach($note['tags'] as $tag)
                                        <a href="/search?kw={{$tag}}" class="tags">{{$tag}}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    @include('mt/layout/share')
                    @if(!empty($recommended))
                        <p style="text-align: left;font-weight: bold;color:grey;margin: .8em;"><i
                                    class="fa fa-link"></i>
                            &nbsp;&nbsp;相关推荐
                        </p>
                        <div class="par-card">
                            @foreach($recommended as $k => $rec)
                                <div class="card-sm">
                                    <div style="height: 10em;background: white url('{{$rec['thumb']}}') no-repeat ;background-size:cover;border-radius: 5px 5px 0 0">
                                    </div>
                                    <div style="height: 8em;padding:.5em;position: relative">
                                        <p style="margin: .5em;font-size: .95em;font-weight:bold; overflow: hidden; height: 1.2em">
                                            <a
                                                    style="color:black"
                                                    href="/note/{{$rec['id']}}.html">{{$rec['title']}}</a>
                                        </p>
                                        <p style="margin: .5em;font-size: .85em;color:#808080; height: 4em; overflow: hidden">
                                            {{mb_substr($rec['text'], 0 , 50)}}
                                        </p>
                                        <div style="position:absolute;bottom:1em;margin:0 .5em;">
                                            <i class="fa fa-bars">&nbsp;&nbsp;{{$rec['type']}}</i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="card">
                        <div
                                style="border-bottom:1px solid #e0e0e0;display: flex;justify-content: space-between;padding:.5em 1em 1em;font-size: .95em">
                            <b>{{$comments_count}}条评论</b>
                            @if(request()->get('order') == 1)
                                <a id="sort" data-id="1" href="?order=0"><span style="color: grey">按时间排序</span></a>
                            @else
                                <a id="sort" data-id="0" href="?order=1"><span style="color: grey">按点赞排序</span></a>
                            @endif
                        </div>
                        <div style="margin:.5em">
                            <form action="" name="form">
                                <input type="hidden" name="comment" value="">
                                <div contenteditable="true"
                                     id="comment-field"></div>
                                <div style="display: flex;justify-content: space-between;box-sizing: border-box">
                                    <input type="text" placeholder="用户名" name="name">
                                    <input type="hidden" name="note_id" value="{{$note['id']}}">
                                    <div style="width: 2.8em;text-align: center;margin: 0 .3em"><i
                                                style="font-size: 2.1em;color: black;cursor:pointer;"
                                                title="输入{狗头}可以发送狗头表情"
                                                class="fa fa-smile-o"></i></div>
                                    <div style="width: 10%;min-width: 3em;">
                                        <input class="btn-submit" type="button"
                                               style="height: 100%; margin-top: 0"
                                               id="comment" value="评论">
                                    </div>
                                </div>
                            </form>
                            <div id="comments">
                                @foreach($comments['top'] as $comment)
                                    <div style="margin: 1em 0 0;font-size: 14px;">
                                        <div style="display: flex;justify-content: space-between;line-height: 2em;height: 2em">
                                            <div><img src="/favicon.ico" alt=""
                                                      style="width: 2em;height: 2em;border-radius: 50%"><b
                                                        style="position:absolute;font-size:14px;height: 2em;margin-left:.5em">
                                                    {{$comment['name']}}</b>
                                            </div>
                                            <span style="color:grey;font-size: 13px">{{time_convert($comment['create_time'])}}</span>
                                        </div>
                                        <div style="padding:.5em 0 0 2.5em;word-break: break-all;word-wrap: break-word;color: #626262">
                                            <div>
                                                <div style="margin-bottom: .5em;display: flex;color: #626262">
                                                    {{nl2br($comment['comment'])}}
                                                </div>
                                            </div>
                                            <div style="font-size:.9em;text-align:right;padding:0 0 .3em;border-bottom: 1px solid #dbdbdb;color: grey">
                                                <i class="fa
@if(empty(\Max\Foundation\Facades\DB::table('hearts')->where('comment_id', $comment['id'])->where('user_id', request()->ip())->exists()))
                                                        fa-heart-o
@else
                                                        fa-heart
@endif like"
                                                   data-id="{{$comment['id']}}"
                                                   style="color: red;cursor:pointer;"></i> <span
                                                        class="count-heart">{{$comment['hearts']}}</span>
                                                <i class="fa fa-comment-o" style="margin-left: 1em"></i><!-- <span
                                        class="review">回复</span>-->
                                            </div>
                                            @foreach($sub_comments as $sub)
                                                @if($sub['parent_id'] == $comment['id'])
                                                    <div style="margin: 1em 0 0;font-size: 14px;">
                                                        <div style="display: flex;justify-content: space-between;line-height: 2em;height: 2em">
                                                            <div><img src="/favicon.ico" alt=""
                                                                      style="width: 2em;height: 2em;border-radius: 50%"><b
                                                                        style="position:absolute;font-size:14px;height: 2em;margin-left:.5em">
                                                                    {{$sub['name']}}</b>
                                                            </div>
                                                            <span style="color:grey;font-size: 13px">{{time_convert($sub['create_time'])}}</span>
                                                        </div>
                                                        <div style="padding:.5em 0 0 2.5em;word-break: break-all;word-wrap: break-word;">
                                                            <div>
                                                                <div style="margin-bottom: .5em;display: flex;color: #626262">
                                                                    {{$sub['comment']}}
                                                                </div>
                                                            </div>
                                                            <div style="text-align:right;padding:0 0 .3em 0;border-bottom: 1px solid #dbdbdb;color: grey;font-size:.9em;">
                                                                <i class="fa fa-heart like" data-id="{{$sub['id']}}"
                                                                   style="color: red;cursor:pointer;"></i> <span
                                                                        class="count-heart">{{$sub['hearts']}}</span>
                                                                <i class="fa fa-comment-o" style="margin-left: 1em"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(count($comments) == 5)
                                <p id="comments-more"
                                   style="font-size:.8em;text-align: center;font-weight: bold;color:grey;margin: 1em 0 .5em;cursor: pointer">
                                    <i class="fa fa-long-arrow-down"></i> &nbsp;&nbsp;加载更多
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <aside class="d-bg">
                    <div id="catalog-box" class="card d-bg">
                        <div class="tips"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;目录</div>
                        <div id="catalog" style="padding:0 .5em;">
                        </div>
                    </div>
                    <div class="card">
                        <div class="tips"><i class="fa fa-fire"></i>&nbsp;&nbsp;推荐</div>
                        <ul class="card-content">
                            @foreach($hots as $hot)
                                <li>
                                    <a href="{{url('read',[$hot['id']])}}">{{$hot['title']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
    </main>
    <div id="poster"
         style="z-index: 99;width: 100%; height: 100vh;background-color: rgba(1,1,1,0.5);position: absolute; top:0; left: 0;display: flex;justify-content: center;align-items: center;visibility: hidden">
        <div style="background-color: white;width: 20em;height: 30em;z-index: 100;opacity: 1;border-radius: 10px;">
            <div style="height: 65%;position: relative">
                <img src="/static/img/2.jpg" style="width: 100%;height:100%;border-radius: 5px 5px 0 0" alt="">
                <div id="poster-close"
                     style="position: absolute;top :calc(.1em - 4px); right: .3em;font-size: 1.5em;font-weight: bold;cursor:pointer;">
                    ×
                </div>
                <div style="background-color:white;padding: .5em;position: absolute;bottom: -4px; right: 0"
                     id="qrcode"></div>
            </div>
            <div style="display: flex;justify-content: space-between;padding:.5em">
                <div></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script src="/static/editor/lib/marked.min.js"></script>
    <script src="/static/editor/lib/prettify.min.js"></script>
    <script src="/static/editor/lib/raphael.min.js"></script>
    <script src="/static/editor/lib/underscore.min.js"></script>
    <script src="/static/editor/lib/sequence-diagram.min.js"></script>
    <script src="/static/editor/lib/flowchart.min.js"></script>
    <script src="/static/editor/lib/jquery.flowchart.min.js"></script>
    <script src="/static/editor/editormd.min.js"></script>
    <script type="text/javascript" src="/static/js/qrcode.min.js" id="corepress_jquery_qrcode-js"></script>
    <script>
        document.onscroll = function () {
            let catalog = document.getElementById('catalog-box');
            if (document.documentElement.scrollTop > 300) {
                catalog.style.position = 'fixed';
                catalog.style.top = '3.8em';
            } else {
                catalog.style.position = 'relative';
                catalog.style.top = 'inherit';
            }
            $('#catalog-box').css('width', $('.card-content')[0].offsetWidth);
        }
    </script>
    <script>
        $(() => {
            jQuery('#qrcode').qrcode({
                render: 'canvas',
                width: 100,
                height: 100,
                text: 'http://www.chengyao.xyz/note/{{$note['id']}}.html'
            });

            var testEditormdView, testEditormdView2;
            testEditormdView2 = editormd.markdownToHTML("test-editormd-view2", {
                htmlDecode: "style,script,iframe",  // you can filter tags decode
                emoji: false,
                taskList: true,
                tex: true,  // 默认不解析
                flowChart: true,  // 默认不解析
                sequenceDiagram: true,  // 默认不解析
            });

            var comment_page = 2;
            $('#comments-more').on('click', function () {
                $.get('/note/{{$note['id']}}/comment/p/' + comment_page++ + '?order=' + $('#sort').attr('data-id'), function (data, status) {
                    if ('success' === status) {
                        if (data.top.length < 5) {
                            $('#comments-more').remove();
                        }
                        for (let i in data.top) {
                            let div = $('<div style="margin: 1em 0 0;font-size: 14px;"></div>');
                            div.html('<div style="display: flex;justify-content: space-between;line-height: 2em;height: 2em"><div><img src="/favicon.ico" alt="" style="width: 2em;height: 2em;border-radius: 50%"><b style="position:absolute;font-size:14px;height: 2em;margin-left:.5em">' + data.top[i].name + '</b></div><span style="color:grey;font-size: 13px">' + time_convert(data.top[i].create_time) + '</span></div><div data-id="' + data.top[i].id + '" style="padding:.5em 0 0 2.5em;word-break: break-all;word-wrap: break-word"><div><div style="margin-bottom: .5em;display: flex;color: #626262">' + data.top[i].comment.replace(/\n/g, '<br>') + '</div></div><div style="text-align:right;padding:0 0 .3em 0;border-bottom: 1px solid #dbdbdb;color: grey;font-size: .9em"><i class="fa fa-heart-o like" data-id="' + data.top[i].id + '" style="color: red;cursor:pointer;"></i> <span class="count-heart">' + data.top[i].hearts + '</span><i class="fa fa-comment-o" style="margin-left: 1em"></i> </div></div></div>');
                            div.appendTo('#comments');
                        }
                        for (let j in data.sub) {
                            let div = $('<div style="margin: 1em 0 0;font-size: 14px;"></div>');
                            div.html('<div style="display: flex;justify-content: space-between;line-height: 2em;height: 2em"><div><img src="/favicon.ico" alt="" style="width: 2em;height: 2em;border-radius: 50%"><b style="position:absolute;font-size:14px;height: 2em;margin-left:.5em">' + data.sub[j].name + '</b></div><span style="color:grey;font-size: 13px">' + time_convert(data.sub[j].create_time) + '</span></div><div style="padding:.5em 0 0 2.5em;word-break: break-all;word-wrap: break-word"><div><div style="margin-bottom: .5em;display: flex;color: grey">' + data.sub[j].comment.replace(/\n/g, '<br>') + '</div></div><div style="text-align:right;padding:0 0 .3em 0;border-bottom: 1px solid #dbdbdb;color: #626262;font-size: .9em"><i class="fa fa-heart-o like" data-id="' + data.sub[j].id + '" style="color: red;cursor:pointer;"></i> <span class="count-heart">' + data.sub[j].hearts + '</span><i class="fa fa-comment-o" style="margin-left: 1em"></i></div></div></div>');
                            div.appendTo('div[data-id=' + data.sub[j].parent_id + ']');
                        }
                    }
                }, 'json');
            });


            $('#comment').on('click', function () {
                // $(this).prop('disabled', true);
                if ($('textarea[name=comment]').val() === '') {
                    return false;
                }
                let data = $(form).serialize();
                $.ajax({
                    url: '/api/notes/comment',
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function (e) {
                        if (e.status) {
                            window.location.reload();
                        } else {
                            alert(e.message);
                        }
                    },
                    error: function (e) {
                        alert('服务器异常!');
                    }
                });
            });

            $('#comment-field').on('input', function () {
                $('input[name=comment]').val($(this).text());
            });

            $('#comments').on('click', '.like', function () {
                console.log($(this));
                let heart = $(this);
                let count = heart.siblings('span.count-heart').text();
                $.ajax({
                    url: '/api/notes/heart/' + heart.attr('data-id'),
                    type: 'get',
                    dataType: 'json',
                    success: function (e) {
                        if (e.status) {
                            heart.removeClass('fa-heart-o').addClass('fa-heart').siblings('span.count-heart').text(++count);
                        } else {
                            heart.removeClass('fa-heart').addClass('fa-heart-o').siblings('span.count-heart').text(--count);
                        }
                    },
                    error: function (e) {
                        alert('服务器异常!');
                    }
                });
            })

            $('.review').on('click', function () {
                let html = $('<form action="" name="form"><textarea style="font-size:.9em;box-sizing:border-box;padding:.5em .5em;outline:none;border:1px solid #dbdbdb;line-height:1.4em;height: 2em;width:100%;min-height:8em;border-radius: 5px;resize:vertical;margin-bottom: .5em;" name="comment" placeholder="留下你的笔迹..."></textarea><div style="display: flex;justify-content: space-between;box-sizing: border-box"><input type="text" placeholder="用户名" name="name" style="font-size:13px;padding:0 .6em;width: 90%;outline:none;border:1px solid #dbdbdb;line-height:2.5em;height: 2.5em;border-radius: 5px;"><input type="hidden" name="note_id" value="122"><div style="font-size: 2.1em;color: #4F70F6;cursor:pointer;" title="输入{狗头}可以发送狗头表情" class="fa fa-smile-o"></i></div><div style="width: 10%;min-width: 3em;"><input type="button" style="height: 100%;cursor:pointer;outline: none;width:100%;border:none;background-color: #4F70F6;color: white;border-radius: 5px" id="comment" value="发布"></div></div></form>');
                html.insertAfter($(this));
            });

            $('#test-editormd-view2 > h1,#test-editormd-view2 h2').each(function (index, element) {
                if ($(element).is('h1')) {
                    $('<a style="font-weight: bold;" href="#' + $(element).attr('id') + '"><i class="fa fa-genderless" style="margin-right: .15em"></i>' + element.innerText + '</a>').appendTo('#catalog');
                } else if ($(element).is('h2')) {
                    $('<a href="#' + $(element).attr('id') + '">&nbsp;&nbsp;&nbsp;' + element.innerText + '</a>').appendTo('#catalog');
                }
                $('#catalog-box').show().css({'width': $('.card-content')[0].offsetWidth, 'top': '3.5em'});
            });

            $('#delete').on('click', function () {
                if (confirm('确认要删除吗？')) {
                    window.location.href = '/notes/delete/{{$note['id']}}';
                }
                return false;
            });
        })

        $('#test-editormd-view2').on('DOMNodeInserted', function () {
            $('#content-loading').remove();
        });

        $(window).on('resize', (e) => {
            $('#catalog-box').css('width', $('.card-content')[0].offsetWidth);
        });

        $('#qrcode-btn').on('click', () => {
            $('#poster').css('visibility', 'visible');
        });
        $('#poster-close').on('click', () => {
            $('#poster').css('visibility', 'hidden');
        })
    </script>
@endsection
