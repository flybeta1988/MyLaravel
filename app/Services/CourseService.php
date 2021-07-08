<?php

namespace App\Services;


/**
 * Class CourseService
 * @package App\Services
 */
class CourseService implements ServiceInterface
{

    public function getType() {
        return 'course';
    }

    /**
     * @return int[]
     */
    public function getList()
    {
        return [4, 5, 6];
    }
}