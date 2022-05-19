@extends('mt/layout/main')
@php
    $message = $message ?? 400
@endphp
@section('title')
    {{$message}}
@endsection
@section('body')
    <div style="height:100vh;background: url('/static/bg/bg{{rand(1, 33)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center; background-size: cover">
        <div style="max-width: 65%">
            <h1 style="font-size: 5em; color: white; text-align: center">
                @if(empty($code))
                    Tips
                @else
                    {{$code}}
                @endif
            </h1>
            <h1 style="color: white; font-weight: bold;font-family: 'Long Cang',cursive;text-align: center;">
                {{$message}}
            </h1>
        </div>

    </div>
    <div style="display: none">
@endsection
