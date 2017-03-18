@extends('layout.master')

@section('title', '新闻创建')

@section('sidebar')
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p><a href="/news">新闻列表</a> </p>
    <div class="news">
        <h3>[{{$news->id}}] {{$news->title}}</h3>
        <p>{{$news->content}}</p>
    </div>
@endsection
