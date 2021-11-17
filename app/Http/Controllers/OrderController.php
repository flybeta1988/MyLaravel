<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private $type;
    private $service;

    public function __construct(ServiceInterface $service, $type)
    {
        $this->type = $type;
        $this->service = $service;
    }

    public function index(Request $request) {
        echo "type:". $this->type. "\n";
        $data = $this->service->getList();
        return $data;
    }

    public function add() {

        $product_id = 1;
        $uid = mt_rand(10000, 99999);

        $msg = '已售罄';

        if (!Order::getFirstByProductId($product_id)) {
            $order = new Order();
            $order->uid = $uid;
            $order->product_id = $product_id;
            $order->save();
            $msg = "恭喜（{$uid}），秒中了！";
            Log::info(__METHOD__. " productId:{$product_id} uid:{$uid} msg:{$msg}");
        }

        return array(
            "msg" => $msg
        );
    }
}
