<?php

namespace App\Console\Commands;

use App\Events\NewSaved;
use App\Events\NewsSavedEvent;
use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NewsCMD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the news list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$news = $this->getChunkObjList();
        //$news = $this->getChunkArrayList();
        //$news = $this->getPluckObjList();
        //$news = $this->getPluckArrayList();
        $result = $this->getFirst();
        dd($result->comments->toArray());
        //print($result->title . "\n");
    }

    private function getFirst() {
        return News::find(1);
    }

    private function getPluckObjList() {
        return News::get()->take(2)->pluck('title');
    }

    private function getPluckArrayList() {
        return DB::table('news')->take(2)->pluck('title', 'id');
    }

    private function getChunkObjList() {
        return News::all()->chunk(2, function ($news) {
            print_r($news);
        });
    }

    private function getChunkArrayList() {
        return DB::table('news')->chunk(2, function ($news) {
            print_r($news);
        });
    }

    private function save() {
        $news = new News();
        $news->title = '中国是最好的国家！'. mt_rand(100, 999);
        $news->content = '111';
        $result = $news->save();
        if ($result) {
            event(new NewsSavedEvent($news));
        }
        return ;
    }

    private function create() {
        $tailStr = mt_rand(1000, 9999);
        $result = News::create(
            array(
                'title' => 'From cmd 测试标题'. $tailStr,
                'content' => 'From cmd 测试内容'. $tailStr
            )
        );
        return $result;
    }
}
