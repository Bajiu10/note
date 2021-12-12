@extends('mt/layout/main')
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center; background-size: cover">
        <h1 style="color: white; font-weight: bold">聊天记录</h1>
    </div>
    <main id="app" style="margin-top: .8em">
        <div id="step1" style="display: flex;justify-content: space-between;">
            <div class="card" style="width:100%;margin-right: .5em">
                @foreach($records as $record)
                    <div style="margin:.5em;color:#2d2626;line-height: 1.1em;text-align: left;font-size: 1.1em;padding:.5em;font-weight: bold">
                        <div style="margin: 1em 0; font-size: .85em; min-height: 4em; display: flex; justify-content: space-between;">
                            <div style="width: 4.5em; height: 4em; background-color: #3b6b7b; color: white; border-radius: 50%; line-height: 4em; padding: .2em; font-size: .8em; text-align: center">
                                ㊙
                            </div>
                            <div style="display: flex; justify-content: space-between; padding-left: 1em; width: 100%; flex-direction: column">
                                <div><b>游客{{$record['id']}}</b></div>
                                <div style="text-align: left; margin: .5em 0"><i>{{$record['data']}}</i></div>
                                <div style="text-align: right; font-size: .8em">
                                    {{time_convert($record['time'])}}</div>
                            </div>
                            <p></p></div>
                    </div>
                @endforeach
            </div>
        </div>
        <ul class="paginate" style="text-align: center">
            {{$paginate}}
        </ul>
    </main>
@endsection
<!-- <script>
    $(() => {
        if ($(document).scrollTop() > 300) {
            $('header').css('background-color', 'rgba(0,0,0,.7)')
        }
    })
    $(document).on('scroll', function () {
        if ($(document).scrollTop() > 300) {
            $('header').css('background-color', 'rgba(0,0,0,.7)')
        } else {
            $('header').css('background-color', 'transparent')
        }
    })
</script> -->
