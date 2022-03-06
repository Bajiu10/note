<style>

    .icon {
        text-align: center;
        margin-right: .2em;
        width: 1.5em;
        height: 2em;
        font-size: 1.3em;
        line-height: 2em;
        cursor: pointer
    }

    #content-box {
        width: 75%;
        border: none;
        border-bottom: 1px solid black;
        outline: none;
    }

    .chat-item {
        margin: 0 0 1em;
        font-size: .85em;
        min-height: 4em;
        display: flex;
        justify-content: space-between;
    }

    .chat-avatar {
        width: 5.5em;
        height: 4em;
        background-color: #3b6b7b;
        color: white;
        border-radius: 50%;
        line-height: 4em;
        padding: .2em;
        font-size: .8em;
        text-align: center
    }

    .chat-content-box {
        display: flex;
        justify-content: space-between;
        padding-left: 1em;
        width: 100%;
        flex-direction: column
    }

    .chat-content {
        text-align: left;
        margin: .5em 0
    }

    .chat-time {
        text-align: right;
        font-size: .8em
    }

    #open-room {
        z-index: 999;
        backdrop-filter: saturate(180%) blur(20px);
        position: fixed;
        bottom: .5em;
        right: .5em;
        height: 3.2em;
        line-height: 3.2em;
        width: 3.2em;
        border-radius: 50%;
        box-shadow: 0 0 4px 1px rgba(128, 128, 128, 0.11);
        background-color: hsla(0, 0%, 100%, .72);
        color: black;
        font-weight: bold;
        font-size: .9em;
        text-align: center;
        cursor: pointer;
    }

    #chat {
        display: none;
        position: fixed;
        bottom: .5em;
        right: .5em;
        height: 33em;
        border-radius: 5px;
        width: 21em;
        box-shadow: 0 0 4px 1px rgba(128, 128, 128, 0.31);
        z-index: 999999999
    }

    .room-header {
        backdrop-filter: saturate(180%) blur(20px);
        height: 10%;
        /*background-color: hsla(0, 0%, 100%, .72);*/
        border-radius: 5px 5px 0 0;
        color: black;
        font-weight: bold;
        line-height: 3em;
        padding: 0 1em;
        font-size: .9em;
        display: flex;
        justify-content: space-between
    }

    #room-content {
        box-sizing: border-box;
        /*padding: .5em;*/
        background-color: white;
        width: 100%;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        border-radius: 0 0 5px 5px;
        height: 90%;
    }

    #chat-room {
        overflow-x: scroll;
        word-break: break-all;
        max-height: 88%;
        padding: .5em
    }

    #message-send-box {
        display: flex;
        justify-content: space-between;
        height: 10%;
    }

    .close-btn {
        height: 1.5em;
        width: 1.5em;
        text-align: center;
        cursor: pointer;
        border-radius: 50%;
        line-height: 1.6em;
        margin: .35em 0;
        font-size: 1.3em;
        transition: background-color .3s;
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
        width: 45px;
        height: 45px;
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

    .close-btn:hover {
        background-color: #e0e0e0;
    }
</style>
<div id="open-room">
    <i class="fa fa-comment"></i>
</div>
<div id="chat">
    <div class="room-header">
        <span>聊天</span>
        {{--        <span>在线<t id="online">0</t></span>--}}
        <span id="close" class="close-btn">×</span>
    </div>
    <div id="room-content">
        <div id="chat-room" class="comment-box-list">
        </div>
        <div id="message-send-box">
            <i class="fa fa-file-image-o icon" id="upload-image" title="选择图片并发送"></i>
            <input type="file" style="display: none" name="chat-image">
            <input type="text" id="content-box" placeholder="最多200字符" maxlength="200">
            <a href="/chat/record" style="color: black;"><i class="fa fa-history icon" aria-hidden="true"
                                                            title="历史记录"></i></a>
            <i class="fa fa-paper-plane-o icon" aria-hidden="true" id="send" title="发送"></i>
        </div>
    </div>
</div>
<script>
    $('#close').on('click', function () {
        $('#chat').slideUp()
    })

    $('#open-room').on('click', function () {
        $('#chat').slideDown()
    })

    function appendMsg(data) {
        const chatRoom = $('#chat-room');
        // const online = $('#online');
        // if (data.data.length > 1) {
        //     chatRoom.html('')
        //     online.text(data.online)
        // }
        chatRoom.prepend(`
  <div class="comment-list">
    <div class="comment-item" id="comment-204">
      <div class="body">
        <div class="avatar">
          <img
            class="lazyload"
            src="https://cdn.shopify.com/s/files/1/1493/7144/products/product-image-16756312_1024x1024.jpg?v=1476865937"
          />
        </div>
        <div class="content">
          <div class="name"><a href="">游客${data.uid}</a></div>
          <div class="info">
            <span class="date">2022/1/15</span>
<!--            <a href="#respond-post-150" rel="nofollow">回复</a>&nbsp;-->
<!--            <a href="#respond-post-150" rel="nofollow">-->
<!--              <i-->
<!--                class="fa fa-heart-o like"-->
<!--                data-id="204"-->
<!--                style="cursor: pointer"-->
<!--              ></i-->
<!--              >&nbsp;<span>1</span>-->
            </a>
          </div>
          <div class="text"><p>${data.data}</p></div>
        </div>
      </div>
    </div>
  </div>
`)
    }

    var ws = new WebSocket('wss://ws.1kmb.com/?id=' + Math.random() * 10);
    ws.onopen = function (evt) {
        ws.onclose = function (evt) {
            console.log("Disconnected");
        };

        ws.onmessage = function (evt) {
            if (evt.data === 'pong') {
                return
            }
            let data = JSON.parse(evt.data)
            if (data.code === 101) {
                for (let i in data.data) {
                    appendMsg(data.data[i])
                }
            } else {
                appendMsg(data.data)
            }
        };

        ws.onerror = function (evt, e) {
            console.log('Error occured: ' + evt.data);
        };

        $('#send').on('click', function (e) {
            input = $('#content-box')
            content = input.val()
            if ('' === content) {
                return
            }
            ws.send(content);
            input.val('')
        })

        $('#upload-image').on('click', function () {
            $('input[name=chat-image]').click()
        })

        $('input[name=chat-image]').on('change', function () {
            var form = new FormData;
            form.append('chat-image', $(this)[0].files[0])
            $.ajax({
                url: '/api/chat/upload',
                type: 'post',
                contentType: false,
                processData: false,
                data: form,
                success: function (e) {
                    ws.send('img:' + e.url)
                    $('input[name=chat-image]').val('')
                },
                error: function (e) {
                    console.log(e)
                }
            });
        })

        $(document).on('keyup', function (e) {
            if (13 === e.keyCode) {
                $('#send').click()
            }
        })

        setInterval(function () {
            ws.send('ping')
        }, 5000)
        console.log("Connected to ws server.");
    };
</script>
