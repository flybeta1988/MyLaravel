<?php

namespace App\Http\Controllers;

use App\Services\ServiceInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $type;
    private $service;
    private $reports;

    public function __construct(ServiceInterface $service, $type, $reports)
    {
        $this->type = $type;
        $this->service = $service;
        $this->reports = $reports;
    }

    public function index(Request $request) {
        echo "type:". $this->type. "\n";
        $data = $this->service->getList();
        return $data;
    }

    public function hello(Request $request) {
        return array(
            "msg" => 'hello laravel'
        );
    }

    public function reflect() {
        $reflector = new \ReflectionClass($this);
        $is_instantiable = $reflector->isInstantiable();
        $constructor = $reflector->getConstructor();
        $dependencies = $constructor->getParameters();
        var_dump($is_instantiable);
        print_r($constructor);
        print_r($dependencies);
    }
}
