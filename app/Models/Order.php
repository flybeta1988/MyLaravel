<?php

namespace App\Models;


use App\Library\Cache\CacheMaintainType;
use App\Library\Cache\CacheUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    /**
     * 设置数据库记录插入时间字段名
     */
    const CREATED_AT = 'ctime';

    /**
     * 设置数据库记录更新字段名
     */
    const UPDATED_AT = 'utime';

    /**
     * 设置数据记录软删除字段名
     */
    const DELETED_AT = 'dtime';

    protected $table = 'orders';

    /**
     * 设置时间格式为unix timestamp
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getFirstByProductId($product_id) {
        //sleep(2);
        return self::where("product_id", $product_id)->first();
    }
}