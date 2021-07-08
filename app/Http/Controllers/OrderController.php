<?php

namespace App\Http\Controllers;

use App\Services\QunService;
use App\Services\ServiceInterface;
use Illuminate\Http\Request;

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
}
