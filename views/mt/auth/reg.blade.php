@extends('mt/layout/main')
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center">
        <h1 style="color: white; font-weight: bold">注册</h1>
    </div>
    <main style="margin: -5em auto 8em;">
        <div class="main login-area">
            <section style="padding:1em;">
                <div style="margin:2% auto">
                    <form action="/login?from={{request()->get('from')}}" method="post" name="reg-form">
                        <label for="username"><i class="fa fa-user"></i>&nbsp;&nbsp;用户名</label>
                        <input id="username" type="text" class="login-input" name="username" required>
                        <label for="email"><i class="fa fa-email"></i>&nbsp;&nbsp;邮箱</label>
                        <input id="email" type="email" class="login-input" name="email" required>
                        <label for="password"><i class="fa fa-key"></i>&nbsp;&nbsp;密码</label>
                        <input id="password" type="password" class="login-input" name="password" required>
                        <label for="password-confirm"><i class="fa fa-key"></i>&nbsp;&nbsp;确认密码</label>
                        <input id="password-confirm" type="password" class="login-input" name="password-confirm"
                               required>
                        <input type="submit" class="btn-submit" value="注册">
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
@section('js')
    <script>
        $.ajax({
            url: '/api/auth/reg',
            type: 'POST',
            data: $('reg-form').serialize(),
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
    </script>
@endsection

