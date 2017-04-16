<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as MongoDBModel;

class Notify extends MongoDBModel
{
    protected $connection = 'mongodb';

    protected $collection = 'notify';

    protected $dateFormat = 'U';

    protected $dates = [
        'dtime'
    ];

}
