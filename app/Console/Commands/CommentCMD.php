<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;

class CommentCMD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:comment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $r = $this->getFirst()->news;
        dd($r);
        var_dump($this->save());
    }
    
    public function save() {
        $c = new Comment();
        $c->content = '不错喽'. mt_rand(1000, 9999);
        $c->nid = 1;
        $c->save();
    }

    public function getFirst() {
        return Comment::find(2);
    }

    public function getList() {
        return Comment::all();
    }
}
