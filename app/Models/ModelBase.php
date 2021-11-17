<?php

namespace App\Models;


use App\Library\Cache\CacheMaintainType;
use App\Library\Cache\CacheUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class ModelBase extends Model
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

    public static $mc_enable = 1;

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

    public function xsave() {
        if ($this->id) {

            $result = $this->save();

            $cache_key = $this->cache_prefix . $this->id;
            /*if (Cache::has($cache_key)) {
                Cache::forget($cache_key);
            }*/
            $this->putCache($cache_key, $this);

            $cache_key = $this->cache_prefix_with_trashed . $this->id;
            /*if (Cache::has($cache_key)) {
                Cache::forget($cache_key);
            }*/
            $this->putCache($cache_key, $this);

            if ($result) {
                static::maintainCache($this, CacheMaintainType::FORWARD);
            }

        } else {
            if (($result = $this->save())) {
                static::maintainCache($this, CacheMaintainType::ADD);

                $cache_key = $this->cache_prefix . $this->id;
                if (Cache::has($cache_key)) {
                    Cache::forget($cache_key);
                }
                $this->putCache($cache_key, $this);

                $cache_key = $this->cache_prefix_with_trashed . $this->id;
                if (Cache::has($cache_key)) {
                    Cache::forget($cache_key);
                }
                $this->putCache($cache_key, $this);
            }
        }
        return $result;
    }

    public function putCache($cache_key, $obj) {
        Cache::put($cache_key, $obj, CacheUtil::getExpire($obj->id));
    }

    public function maintainCache($rowObj, $type, $expire = 1440) {
        ;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function xget($id) {
        if (!($id > 0)) {
            return null;
        }

        $cache_key = get_called_class() . ':' . $id;
        if (self::$mc_enable && Cache::has($cache_key)) {
            $rowObj = Cache::get($cache_key);
            Log::info(__METHOD__. " {$cache_key} from cache!");
        } else {
            if (($rowObj = self::find($id))) {
                Cache::put($cache_key, $rowObj, CacheUtil::getExpire($rowObj->id));
            }
            Log::info(__METHOD__. " {$cache_key} from db!");
        }
        return $rowObj;
    }
}