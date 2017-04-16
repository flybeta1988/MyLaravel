<?php

namespace App\Http\Controllers;

use App\Models\Notify;
use Mockery\Matcher\Not;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifyController extends Controller
{
    public function index(Request $request) {
        //$notifyList = Notify::getBaseDetail(1);
        //$notifyList = DB::connection('mongodb')->collection('notify')->first();
        $notifyList = Notify::all();
        dd($notifyList);
    }

    public function save(Request $request) {
        $notify = new Notify();
        $notify->method = 'alipay';
        $notify->order_code = 'D'.date('YmdHis').mt_rand(1000, 9999);
        $result = $notify->save();
        dd($result);
    }
}
