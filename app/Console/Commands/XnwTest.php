<?php

namespace App\Console\Commands;

use App\Models\Test;
use App\Services\CourseService;
use App\Services\OrderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class XnwTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xnw:test {option} {xid?} {name?}';

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
        //Log::info(__METHOD__);

        $option = $this->argument('option');

        $method = $option; //lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $option))));

        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            dd('invalid option:' . $option);
        }
    }

    function test01() {
        $test = Test::find(2);
        //$test->delete();
        $test->forceDelete();
        dd(111);
        $test = new Test();
        //$test = Test::find(1);
        $test->name = 'ccc';
        $test->save();
        dd($test->id);

        App::bind('foo', OrderService::class);
        $foo = App::make('foo');
        var_dump($foo->getList());
    }

    function testDBTransation() {

    }
}
