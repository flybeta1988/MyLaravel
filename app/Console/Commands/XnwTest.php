<?php

namespace App\Console\Commands;

use App\Services\CourseService;
use App\Services\OrderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class XnwTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xnw:test';

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
     * @return int
     */
    public function handle()
    {
        App::bind('foo', OrderService::class);
        $foo = App::make('foo');
        var_dump($foo->getList());
    }
}
