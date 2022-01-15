@extends('mt/layout/main')
@section('title')
    {!! $note['title'] !!} | MaxPHP - 组件化的轻量PHP框架
@endsection

@section('head')
    <meta name="description" content="{!! $note['abstract'] !!}">
    <link rel="stylesheet" href="/static/editor/css/editormd.preview.css"/>
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
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
                            class="fa fa-comment"></i>&nbsp;{{$commentsCount}}
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
                            <b>{{$commentsCount}}条评论</b>
                            <a id="sort" data-id="0" href="javascript: void(0)"><span
                                        style="color: grey">按时间排序</span></a>
                        </div>
                        <div style="margin:.5em">
                            <form action="" name="form">
                                <input type="hidden" name="comment" value="">
                                <div contenteditable="true"
                                     id="comment-field"></div>
                                <div style="display: flex;justify-content: space-between;box-sizing: border-box">
                                    <input type="text" placeholder="用户名" name="name">
                                    <input type="hidden" name="note_id" value="{{$note['id']}}">
                                    <div id="select-meme" style="width: 2.8em;text-align: center;margin: 0 .3em"><i
                                                style="font-size: 2.1em;color: black;cursor:pointer;"
                                                class="fa fa-smile-o"></i></div>
                                    <div style="width: 2em;">
                                        <input type="hidden" id="TencentCaptcha" data-appid="2004706694"
                                               data-cbfn="callbackName"
                                               data-biz-state="data-biz-state">
                                        <i id="comment"
                                           style="cursor: pointer; line-height: 1.4em; font-size: 1.5em"
                                           class="fa fa-paper-plane-o" aria-hidden="true" title="发送"></i>
                                    </div>
                                </div>
                                <div id="meme" style="margin-top: .5em; display: none">
                                </div>
                            </form>
                            <!--点击此元素会自动激活验证码, 此例使用的button元素, 也可以使用div、span等-->
                            <!--id :            (不可变) 元素的 ID, 值必须是 "TencentCaptcha"-->
                            <!--data-appid :    (必须) 验证码CaptchaAppId, 从腾讯云的验证码控制台中获取, 验证码控制台页面内【图形验证】>【验证列表】进行查看 。如果未新建验证，请根据业务需求选择适合的验证渠道、验证场景进行新建-->
                            <!--data-cbfn :     (必须) 回调函数名, 函数名要与 data-cbfn 相同-->
                            <!--data-biz-state :(可选) 业务自定义透传参数, 会在回调函数内获取到 （res.bizState）-->
                            {{--                            <button id="TencentCaptcha" data-appid="2004706694" data-cbfn="callbackName"--}}
                            {{--                                    data-biz-state="data-biz-state" type="button">验证--}}
                            {{--                            </button>--}}
                            <style>
                                p {
                                    margin-top: 0;
                                    margin-bottom: 1rem;
                                }

                                a {
                                    color: #0d6efd;
                                    text-decoration: underline;
                                }

                                ::-moz-focus-inner {
                                    padding: 0;
                                    border-style: none;
                                }

                                a {
                                    text-decoration: none;
                                }

                                .comment-title {
                                    font-weight: 700;
                                    letter-spacing: -0.025em;
                                    padding: 0.5rem 0.5rem 0 0.5rem;
                                }

                                .comment-list .comment-item {
                                    padding: .5rem;
                                    margin-top: 1rem;
                                }

                                .comment-list .comment-item .body {
                                    display: flex;
                                }

                                .comment-list {
                                    padding: 0;
                                }

                                .comment-list .comment-item .avatar {
                                    margin-right: 0.75rem;
                                    position: relative;
                                }

                                .comment-list .comment-item .avatar img {
                                    width: 32px;
                                    height: 32px;
                                    border-radius: 8px;
                                }

                                .comment-list .comment-item .avatar .avatar-dd {
                                    position: absolute;
                                    width: 10px;
                                    height: 10px;
                                    border-radius: 50rem;
                                    background-color: var(--theme-color);
                                    top: 26px;
                                    left: 26px;
                                    border: 2px solid #fff;
                                }

                                .comment-list .comment-item .content .name a {
                                    font-size: .9rem;
                                    font-weight: 700;
                                    color: var(--color-text);
                                }

                                .comment-list .comment-item .content .text {
                                    font-size: .85rem;
                                    padding: .8rem;
                                    font-weight: 400;
                                    background-color: #f5f5f5;
                                    border-radius: 0 .8rem .8rem .8rem;
                                    letter-spacing: .08rem;
                                    line-height: 1.45rem;
                                    color: var(--color-title);
                                    text-align: justify;
                                    margin-top: .25rem;
                                }

                                .comment-list .comment-item .content .text p {
                                    margin: 0;
                                    display: inline;
                                    word-wrap: break-spaces;
                                    word-break: break-word;
                                }

                                .comment-list .comment-item .content .info, .comment-list .comment-item .content .info a {
                                    font-size: .75rem;
                                    font-weight: 400;
                                    color: #aab1ce;
                                }

                                .comment-list .comment-item .content .info a:hover {
                                    border-bottom: 1px solid var(--color-text);
                                    color: var(--color-text);
                                }

                                .comment-box-list > .comment-list > .children {
                                    margin-left: 2.75rem;
                                }

                                .comment-list .children .comment-item .reply-name {
                                    font-weight: 700;
                                    padding-right: .25rem;
                                }

                                @media (max-width: 991.98px) {
                                    .comment-list .comment-item .content .name {
                                        font-size: .8rem;
                                        font-weight: 700;
                                        color: var(--color-text);
                                    }

                                    .comment-list .comment-item .content .text {
                                        font-size: .75rem;
                                        padding: .8rem;
                                        letter-spacing: .1rem;
                                        line-height: 1.2rem;
                                        margin-top: .25rem;
                                    }

                                    .comment-list .comment-item .content .info, .comment-list .comment-item .content .info a {
                                        font-size: .65rem;
                                        font-weight: 400;
                                    }

                                    .comment-box-list > .comment-list > .children {
                                        padding-left: .75em;
                                        margin-left: .5rem;
                                        border-left: .125rem solid #f5f5f5;
                                    }
                                }
                            </style>
                            <div class="comment-box-list" id="comments">
                                <div class="comment-list">

                                </div>
                            </div>
                            <p id="comments-more"
                               style="font-size:.8em;text-align: center;font-weight: bold;color:grey;margin: 1em 0 .5em;cursor: pointer">
                                <i class="fa fa-long-arrow-down"></i> &nbsp;&nbsp;加载更多
                            </p>
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
                                    <a href="/note/{{$hot['id']}}.html">{{$hot['title']}}</a>
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
        // 回调函数需要放在全局对象window下
        window.callbackName = function (res) {
            // $(this).prop('disabled', true);
            // 返回结果
            // ret         Int       验证结果，0：验证成功。2：用户主动关闭验证码。
            // ticket      String    验证成功的票据，当且仅当 ret = 0 时 ticket 有值。
            // CaptchaAppId       String    验证码应用ID。
            // bizState    Any       自定义透传参数。
            // randstr     String    本次验证的随机串，请求后台接口时需带上。
            // console.log("callback:", res);
            // res（用户主动关闭验证码）= {ret: 2, ticket: null}
            // res（验证成功） = {ret: 0, ticket: "String", randstr: "String"}
            if (res.ret === 0) {
                // 复制结果至剪切板
                // let str = `【randstr】->【${res.randstr}】      【ticket】->【${res.ticket}】`
                // let ipt = document.createElement("input");
                // ipt.value = str;
                // document.body.appendChild(ipt);
                // ipt.select();
                // document.execCommand("Copy");
                // document.body.removeChild(ipt);
                // alert("1. 返回结果（randstr、ticket）已复制到剪切板，ctrl+v 查看。2. 打开浏览器控制台，查看完整返回结果。");
                let data = $(form).serialize();
                data += `&ticket=${res.ticket}&randstr=${res.randstr}`
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
            }
        }

        $('#comment').on('click', function () {
            if (0 === $('#comment-field').text().length) {
                return false;
            }
            $('#TencentCaptcha').click();
        })

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

        $(() => {
            let testEditormdView, testEditormdView2;
            testEditormdView2 = editormd.markdownToHTML("test-editormd-view2", {
                htmlDecode: "style,script,iframe",  // you can filter tags decode
                emoji: false,
                taskList: true,
                tex: true,  // 默认不解析
                flowChart: true,  // 默认不解析
                sequenceDiagram: true,  // 默认不解析
            });

            let page = 1;
            let meme = [
                '{汗}', '{囧}', '{斜眼笑}', '{生气}', '{哈欠}', '{滑稽}', '{笑哭}', '{抠鼻}', '{叹气}', '{挨揍}', '{吃瓜}', '{托腮}', '{偷看}', '{吹水}', '{黑线}', '{严肃}', '{鞭炮}', '{打脸}', '{滑稽2}', '{捂嘴}', '{睡觉}', '{挑逗}', '{狗头}', '{上吊}', '{摸头}', '{鸡冻}', '{厉害}'
            ]

            $('#select-meme').on('click', function () {
                $('#meme').slideToggle()
            })

            let memeBox = $('#meme')
            for (let i in meme) {
                memeBox.append(`<img src="/static/img/meme/${i}.png" alt="" title="${meme[i]}" class="meme">`)
            }

            let commentField = $('#comment-field')
            $('.meme').on('click', function () {
                let commentText = commentField.html()
                commentField.text(commentText + $(this).attr('title'))
                $('input[name=comment]').val(commentField.text());
            })

            const sortElement = $('#sort')
            let sort = sortElement.attr('data-id')
            const sortText = ['按时间排序', '按人气排序']
            sortElement.on('click', function () {
                sort = 0 == sort ? 1 : 0
                $(this).children('span').text(sortText[sort])
                page = 1
                loadComments(page, sort, true)
            })

            function loadComments(page, sort, refresh) {
                $.get('/api/notes/{{$note['id']}}/comments/?page=' + page + '&order=' + sort, function (data, status) {
                    data = data.data.data
                    let commentList;
                    if ('success' === status) {
                        // if (data.length < 5) {
                        //     $('#comments-more').remove();
                        // }
                        commentList = $('.comment-list')
                        if (refresh) {
                            commentList.children().remove();
                        }
                        for (let i in data) {
                            for (let j in meme) {
                                data[i].comment = data[i].comment.replaceAll(meme[j], `<img src="/static/img/meme/${j}.png" class="meme">`)
                            }
                            let hearted = data[i].hearted ? 'fa-heart' : 'fa-heart-o';
                            commentList.append($(`<div class="comment-item" id="comment-37">
    <div class="body">
        <div class="avatar">
            <img class="lazyload"
                 src="https://cdn.shopify.com/s/files/1/1493/7144/products/product-image-16756312_1024x1024.jpg?v=1476865937">
        </div>
        <div class="content">
            <div class="name"><a href="http://biana.cn">${data[i].name}</a></div>
            <div class="info"><span class="date">${time_convert(data[i].create_time)}</span>
                <a href="#respond-post-150" rel="nofollow">回复</a>&nbsp;
                <a href="#respond-post-150" rel="nofollow">
                    <i class="fa ${hearted} like" data-id="${data[i].id}" style="cursor:pointer;"></i>&nbsp;<span>${data[i].hearts}</span>
                </a>
            </div>
            <div class="text"><p>${data[i].comment}</p></div>
        </div>
    </div>
</div>`))
                            if (data[i].children.length > 0) {
                                commentList.append($('<div class="children"><div class="comment-list">'))
                                child = data[i].children
                                for (let i in child) {
                                    for (let j in meme) {
                                        child[i].comment = child[i].comment.replaceAll(meme[j], `<img src="/static/img/meme/${j}.png" class="meme">`)
                                    }
                                    hearted = child[i].hearted ? 'fa-heart' : 'fa-heart-o';
                                    $('.comment-list').append($(`
        <div class="comment-item" id="comment-38">
            <div class="body">
                <div class="avatar">
                    <img class="lazyload"
                         src="https://cdn.shopify.com/s/files/1/1493/7144/products/product-image-16756312_1024x1024.jpg?v=1476865937">
                    <span class="avatar-dd"></span></div>
                <div class="content">
                    <div class="name"><a href="https://yuanm.ren">${child[i].name}</a></div>
                    <div class="info"><span class="date">${time_convert(data[i].create_time)}</span>
                        <a href="#respond-post-150" rel="nofollow">回复</a>&nbsp;
                        <a href="#respond-post-150" rel="nofollow">
                             <i class="fa ${hearted} like" data-id="${child[i].id}" style="cursor:pointer;"></i>&nbsp;<span>${child[i].hearts}</span>
                         </a>
                    </div>
                    <div class="text"><span class="reply-name">@${data[i].name}</span>
                        <p>${child[i].comment}</p></div>
                </div>
            </div>
        </div>

    </div>
</div>
`))
                                }
                                commentList.append($('</div></div>'))
                            }
                        }
                    }
                }, 'json');
            }

            loadComments(page, sort)
            $('#comments-more').on('click', function () {
                loadComments(++page, sort)
            });

            $('#comment-field').on('input', function () {
                $('input[name=comment]').val($(this).text());
            });

            $('.comment-list').on('click', '.like', function () {
                let heart = $(this);
                let count = heart.siblings('span').text();
                $.ajax({
                    url: '/api/notes/heart/' + heart.attr('data-id'),
                    type: 'get',
                    dataType: 'json',
                    success: function (e) {
                        if (e.code === 1) {
                            heart.removeClass('fa-heart-o').addClass('fa-heart').siblings('span').text(++count);
                        } else {
                            heart.removeClass('fa-heart').addClass('fa-heart-o').siblings('span').text(--count);
                        }
                    },
                    error: function (e) {
                        alert('服务器异常!');
                    }
                });
            })
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
    </script>
@endsection
