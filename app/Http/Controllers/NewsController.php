<?php

namespace App\Http\Controllers;

use App\Events\NewSaved;
use App\Http\Service\OrderService;
use App\Library\Util\CacheMaintain;
use App\ModelMiddle\NewsMiddle;
use App\Models\News;
use App\Providers\NewsServiceProvider;
use App\Xnw\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
        DB::enableQueryLog();
        $newsList = News::with('comments')->find([1, 32, 33]);
        $sql = DB::getQueryLog();
        //var_dump($sql);
        //$news_list = DB::table('news')->limit(5)->get();
        //Debugbar::info($news_list);
        //Debugbar::info($news_list);

        /*News::chunk(2, function ($new_list) {
            foreach ($new_list as $new) {

            }
        });*/

        return view('news.index', ['news_list' => $newsList]);
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
        $title = '北京限购政策最新消息'. $tailf;
        $content = '最新北京限购政策最新消息昨晚已出台...'. $tailf;

        $news = new News();
        $news->title = $title;
        $news->content = $content;
        $news->ctime = $datetime;
        $news->utime = $datetime;
        $news->xsave();

        $id = $news->id;

        /*$id = DB::table('news')->insertGetId(
            array(
                'title' => $title,
                'content' => $content,
                'user_id' => 0,
                'status' => 0,
                'created_at' => $datetime
            )
        );*/

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
        News::xsave();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);
        //Log::debug($news);
        Debugbar::info($news);
        //DB::enableQueryLog();

        $news = DB::table('news')->where('id', $id)->first();
        Debugbar::info($news);

        $new_list = News::where('id', '>', 0)->first();
        Debugbar::info($new_list);

        $new_list = News::where('id', '>', 0)->get();
        Debugbar::info($new_list);

        $new_list = DB::table('news')->where('id', '>', 0)->get();
        Debugbar::info($new_list);
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
        $news  = News::find($id);
        $news->content = mt_rand(1000, 9999);
        $news->xsave();
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

    public function delete($id)
    {
        $news = News::find($id);
        if (!is_null($news)) {
            return $news->xdelete($id);
        }
        return false;
    }

    public function foo()
    {
        echo 'Foo !!';
    }

    public function getUserList() {

    }
}
