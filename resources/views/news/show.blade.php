@extends('layout.master')

@section('title', '新闻')

@section('sidebar')
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

<style>
    .news{
        border: 1px solid #ccc;
        margin: 10px 5px;
        padding: 5px;
    }
</style>
@section('content')
    <p>This is my body content.</p>
    <p>当前时间截：{{time()}}</p>

    <p><a href="/news/create">创建新闻</a> </p>
    <p><a href="/news">新闻列表</a> </p>

    <div class="news_list">
        <div class="news">
            <h3>[{{$news->id}}] {{$news->title}}</h3>
            <p>{{$news->content}}</p>
        </div>
    </div>
@endsection
