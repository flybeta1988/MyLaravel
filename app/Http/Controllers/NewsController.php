<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facade AS Debugbar;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news_list = DB::table('news')->limit(5)->get();
        Debugbar::info($news_list);
        return view('news.index', ['news_list' => $news_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tailf = mt_rand(1000, 9999);
        $datetime = date('Y-m-d H:i:s');

        $id = DB::table('news')->insertGetId(
            array(
                'title' => '北京限购政策最新消息'. $tailf ,
                'content' => '最新北京限购政策最新消息昨晚已出台...'. $tailf,
                'user_id' => 0,
                'status' => 0,
                'created_at' => $datetime
            )
        );

        $news = DB::table('news')->where('id', $id)->first();
        return view('news.create', array(
            'news' => $news,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DB::enableQueryLog();
        $news = DB::table('news')->where('id', $id)->first();
        //print_r(DB::getQueryLog());
        return view('news.show', ['news' => $news]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::find($id);
        return view('news.show', ['news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function foo()
    {
        echo 'Foo !!';
    }

    public function getUserList() {

    }
}
