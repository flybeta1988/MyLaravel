<?php

namespace App\Services;


class OrderService implements ServiceInterface
{

    public function getList()
    {
        return array(
            1, 2, 3
        );
    }
}