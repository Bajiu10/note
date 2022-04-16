@extends('mt/layout/main')
@section('body')
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center">
        <h1 style="color: white; font-weight: bold">Login</h1>
    </div>
    <main style="margin: -5em auto 8em;">
        <div class="main login-area">
            <section style="padding:1em;">
                <div style="margin:2% auto">
                    <form name="form">
                        <label for="email"><i class="fa fa-user"></i>&nbsp;&nbsp;邮箱</label>
                        <input id="email" type="email" class="login-input" name="email" required>
                        <label for="password"><i class="fa fa-key"></i>&nbsp;&nbsp;密码</label>
                        <input id="password" type="password" class="login-input" name="password" required>
                        <div style="display: flex;justify-content: space-between">
                            <input type="button" id="TencentCaptcha"
                                   class="btn-submit" value="登录">
                            <input type="button" class="btn-submit" value="注册"
                                   onclick="javascript: window.location='/reg?from={{request()->get('from', '/')}}'">
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
@section('js')
    <script>
        var tcaptchaCallback = function (res) {
            // 返回结果
            // ret         Int       验证结果，0：验证成功。2：用户主动关闭验证码。
            // ticket      String    验证成功的票据，当且仅当 ret = 0 时 ticket 有值。
            // CaptchaAppId       String    验证码应用ID。
            // bizState    Any       自定义透传参数。
            // randstr     String    本次验证的随机串，请求后台接口时需带上。
            console.log('callback:', res);
            // res（用户主动关闭验证码）= {ret: 2, ticket: null}
            // res（验证成功） = {ret: 0, ticket: "String", randstr: "String"}
            // res（客户端出现异常错误 仍返回可用票据） = {ret: 0, ticket: "String", randstr: "String",  errorCode: Number, errorMessage: "String"}
            if (res.ret === 0) {
                let data = $('form').serialize();
                data += `&ticket=${res.ticket}&randstr=${res.randstr}`
                $.ajax({
                    url: '/api/auth/login',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (e) {
                        if (e.status) {
                            window.location.href = "{{request()->get('from')}}";
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
        $(document).ready(function () {
            var captcha1 = new TencentCaptcha('2046626881', tcaptchaCallback);
            $("#TencentCaptcha").click(function () {
                captcha1.show();
            })
        })
    </script>
@endsection
