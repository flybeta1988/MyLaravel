<?php
namespace App\Models;

use App\Library\Cache\CacheConstant;
use App\Library\Cache\CacheMaintainType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

abstract class XnwModel extends Model
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

    /**
     * 设置时间格式为unix timestamp
     *
     * @var string
     */
    //protected $dateFormat = 'U';

    /**
     * laravel 会把以下字段当做日期，并转化为对象
     *
     * @var array
     */
    protected $dates = [
        'expire_time',
        'ctime',
        'utime',
        'dtime',
        'deadline',
    ];

    /**
     * 默认7天缓存
     * @var null|static
     */
    protected $cache_time = null;

    protected $cache_prefix = '';

    public function __construct(array $attributes = [])
    {
        $this->cache_time = Carbon::now()->addDays(7);
        parent::__construct($attributes);
        $this->cache_prefix = get_called_class(). ':';
    }

    public function xsave() {
        if ($this->id) {

            $result = $this->save();

            $cache_key = $this->cache_prefix . $this->id;
            Cache::put($cache_key, $this, CacheConstant::SHORT_EXPIRE_TIME_MINUTES);

        } else {
            $result = $this->save();
            static::maintainCache($this, CacheMaintainType::ADD);
        }
        return $result;
    }

    public function xdelete() {

        $cache_key = $this->cache_prefix . $this->id;
        Cache::pull($cache_key);

        static::maintainCache($this, CacheMaintainType::DELETE);

        return $this->delete();
    }

    public static function maintainCache($rowObj, $type, $expire=1440) {
        ;
    }

    public static function xget($id) {
        $cache_key = get_called_class().':'. $id;
        if (Cache::has($cache_key)) {
            $rowObj = Cache::get($cache_key);
        } else {
            $rowObj = self::find($id);
            Cache::put($cache_key, $rowObj, CacheConstant::SHORT_EXPIRE_TIME_MINUTES);
        }
        return $rowObj;
    }

    public static function xgetList($id_list) {
        $ret = $not_hit_list = array();
        $_mc_prefix = get_called_class().':';
        foreach($id_list as $id) {
            $cache_key = $_mc_prefix.$id;
            if (Cache::has($cache_key)) {
                $ret[$id] = Cache::get($cache_key);
            } else {
                $not_hit_list[] = $id;
            }
        }

        //为了省一步 array_chunk
        if(sizeof($not_hit_list) > CacheConstant::MC_KEYS_LIMIT) {
            $slice_id_list = array_chunk($not_hit_list, CacheConstant::MC_KEYS_LIMIT);
            foreach($slice_id_list as $_id_list) {
                $ret += self::xgetListCache($_id_list, $_mc_prefix);
            }
        } else {
            $ret += self::xgetListCache($not_hit_list, $_mc_prefix);
        }

        //保证按序返回
        $return = array();
        foreach($id_list as $id) {
            if(isset($ret[$id]) && $ret[$id]) {
                $return[$id] = $ret[$id];
            }
        }
        return $return;
    }

    private static function xgetListCache($id_list, $_mc_prefix) {
        $ret = array();

        if (!$id_list) {
            return $ret;
        }

        $cache_id_list = array();
        foreach($id_list as $id) {
            $cache_id_list[$id] = $_mc_prefix . $id;
        }

        //命中
        if(Cache::has($cache_id_list) && ($ret_mc = Cache::get($cache_id_list))) {
            //部分命中
            $not_hit = array();
            foreach($cache_id_list as $id => $cache_id) {
                if(isset($ret_mc[$cache_id]) && ($row = $ret_mc[$cache_id]) && !is_null($row)) {
                    $ret[$id] = $row;
                } else {
                    $not_hit[] = $id;
                }
            }
            if ($not_hit){
                $ret += self::xgetListReal($not_hit);
            }
        } else {
            //全部未命中！直接调用 real 版本得到结果
            $ret = self::xgetListReal($id_list);
        }
        //保证按序返回
        $return = array();
        foreach($id_list as $id) {
            if(isset($ret[$id]) && $ret[$id]) {
                $return[$id] = $ret[$id];
            }
        }
        return $return;
    }

    private static function xgetListReal($id_list) {
        if($id_list) {
            try {
                $ret = array();
                $model_class = get_called_class();
                $_mc_prefix = $model_class. ':';
                foreach ($model_class::whereIn('id', $id_list)->cursor() as $row) {
                    Cache::put($_mc_prefix. $row->id, $row, CacheConstant::SHORT_EXPIRE_TIME_MINUTES);
                    $ret[$row->id] = $row;
                }
                return $ret;
            } catch (\Exception $e) {
                Log::error('file:' . $e->getFile() . ' line:' . $e->getLine()
                    . $e->getMessage() . $e->getTraceAsString());
            }
        }
        return array();
    }


    public static function xtoArray($objList) {
        if (!$objList) {
            return [];
        }

        foreach ($objList as &$obj) {
            $obj = $obj->toArray();
        }

        return $objList;
    }
}
