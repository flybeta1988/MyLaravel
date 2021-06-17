<?php

namespace App\Http\Controllers;

use App\Services\ServiceInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $service;

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index() {
        $data = $this->service->getList();
        dd($data);
    }
}
