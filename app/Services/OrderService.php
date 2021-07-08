<?php

namespace App\Services;


class OrderService implements ServiceInterface
{

    public $id;

    public function getType() {
        return 'order';
    }

    public function getList()
    {
        return array(
            1, 2, 3
        );
    }
}