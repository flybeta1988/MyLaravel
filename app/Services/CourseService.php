<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

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
        /*$data[] = DB::selectOne('select id,wid from weibo_footprint order by id asc limit 130000, 1');
        $data[] = Db::selectOne('select id,wid from weibo_footprint order by id asc limit 140000, 1');
        $data[] = Db::selectOne('select id,wid from weibo_footprint order by id asc limit 150000, 1');*/

        $data[] = DB::selectOne('select id,wid from weibo_footprint where id > 130000 order by id asc limit 1');
        $data[] = DB::selectOne('select id,wid from weibo_footprint where id > 140000 order by id asc limit 1');
        $data[] = DB::selectOne('select id,wid from weibo_footprint where id > 150000 order by id asc limit 1');
        return $data;
    }
}