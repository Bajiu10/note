@extends('mt/layout/main')
@section('body')
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center">
        <h1 style="color: white; font-weight: bold">注册</h1>
    </div>
    <main style="margin: -5em auto 8em;">
        <div class="main login-area">
            <section style="padding:1em;">
                <div style="margin:2% auto">
                    <form name="form">
                        <label for="username"><i class="fa fa-user"></i>&nbsp;&nbsp;用户名</label>
                        <input id="username" type="text" class="login-input" name="username" required>
                        <label for="email"><i class="fa fa-email"></i>&nbsp;&nbsp;邮箱</label>
                        <input id="email" type="email" class="login-input" name="email" required>
                        <label for="password"><i class="fa fa-key"></i>&nbsp;&nbsp;密码</label>
                        <input id="password" type="password" class="login-input" name="password" required>
                        <label for="avatar"><i class="fa fa-key"></i>&nbsp;&nbsp;头像(点击头像更换)</label>
                        <div style="padding: .5em">
                            <img style="width: 6em; height: 6em;" id="avatar"
                                 src="https://cdn.shopify.com/s/files/1/1493/7144/products/product-image-16756312_1024x1024.jpg?v=1476865937"
                                 alt="">
                            <input style="display: none" type="file" id="upload-avatar">
                        </div>
                        <input type="button" class="btn-submit" id="TencentCaptcha" data-appid="2004706694"
                               data-cbfn="callbackName"
                               data-biz-state="data-biz-state" value="注册">
                        <input type="button" class="btn-submit" value="登录"
                               onclick="javascript: window.location='{{request()->get('from', '/')}}'">
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
@section('js')
    <script>
        $('#avatar').on('click', function () {
            $('#upload-avatar').click()
        })
        $('#upload-avatar').on('change', function () {
            let formData = new FormData
            formData.append('chat-image', $(this)[0].files[0])
            $.ajax({
                url: '/api/chat/upload',
                type: 'post',
                contentType: false,
                processData: false,
                data: formData,
                success: function (e) {
                    $('#avatar').attr('src', e.data.url)
                },
                error: function (e) {
                    console.log(e)
                }
            });
        })
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
                let data = $('form').serialize();
                let avatar = $('#avatar').attr('src')
                data += `&ticket=${res.ticket}&randstr=${res.randstr}&avatar=${avatar}`
                $.ajax({
                    url: '/api/auth/reg',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (e) {
                        if (e.status) {
                            window.location.href = "/login?from=https://www.1kmb.com";
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
    </script>
@endsection

