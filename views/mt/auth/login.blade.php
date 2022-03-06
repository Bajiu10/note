@extends('mt/layout/main')
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center">
        <h1 style="color: white; font-weight: bold">Login</h1>
    </div>
    <main style="margin: -5em auto 8em;">
        <div class="main login-area">
            <section style="padding:1em;">
                <div style="margin:2% auto">
                    <form action="/login?from={{request()->get('from')}}" method="post">
                        <label for="username"><i class="fa fa-user"></i>&nbsp;&nbsp;用户名</label>
                        <input id="username" type="text" class="login-input" name="username" required>
                        <label for="password"><i class="fa fa-key"></i>&nbsp;&nbsp;密码</label>
                        <input id="password" type="password" class="login-input" name="password" required>
                        <input type="submit" class="btn-submit" value="登录">
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
