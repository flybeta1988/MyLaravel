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

    <div class="news_list">
        @foreach($news_list as $news)
        <div class="news">
            <h3>[{{$news->id}}]<a href="/news/{{$news->id}}"> {{$news->title}}</a></h3>
            <p>{{$news->content}}</p>
            <p>{{$news->status_str}}</p>
        </div>
        @endforeach
    </div>
@endsection
