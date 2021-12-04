@extends('mt/layout/main')
@section('title')
    {{$keyword}} | MaxPHP - 基于组件的轻量PHP框架！
@endsection
@section('head')
@endsection
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 9)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center; background-size: cover">
        <h1 style="color: white; font-weight: bold">{{$keyword}}</h1>
    </div>
    <main style="margin-top: -5em">
        <div class="container">
            <div class="blog-text">
                <div class="card">
                    @include('mt/layout/list')
                </div>
                <ul class="paginate" style="text-align: center">
                    {!! $paginate !!}
                </ul>
            </div>
        </div>
    </main>
@endsection
