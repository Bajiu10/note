@extends('mt.layout.main')
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center; background-size: cover">
        <h1 style="color: white; font-weight: bold">About</h1>
    </div>
    <main id="app" style="margin-top: .8em">
        <div class="par-card" style="margin-bottom: .5em">
            @foreach($books as $book)
                <div class="card-sm card-sm-4" style="height: 10em; width: 25%">
                    <div class="sm-back">
                        <a href="https://github.com/topyao/max"><img
                                    src="{{$book->cover}}" alt=""
                                    style="width: 100%; height: 100%"></a>
                    </div>
                    <div class="sm-title">
                        <a href="https://www.1kmb.com/note/282.html">MaxFPM开发文档</a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
