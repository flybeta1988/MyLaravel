<?php
/**
 * 维护ID缓存列表工具类
 */

namespace App\Library\Util;


use Illuminate\Support\Facades\Cache;

class CacheMaintain
{
    /**
     * 添加id串的缓存,单纯用于维护ID类型的串
     */
    public static function addId($cache_id, $id, $expire=1440, $delimiter=',', $always_add=false) {
        if(false !== ($id_str = Cache::get($cache_id)) || $always_add) {
            $id_str = $id_str ? $id_str : '';
            if (!\Util::isExistInIdStr($id_str, $id, $delimiter)) {
                $id_str = \Util::addIdToIdStr($id_str, $id, $_reverse=false, $delimiter);
                return Cache::put($cache_id, $id_str, $expire);
            }
        }
        return false;
    }

    /**
     * 移除Id串的缓存,单纯用户维护ID类型的串
     */
    public static function removeId($cache_id, $id, $expire=1440, $delimiter=',') {
        if(false !== ($id_str = Cache::get($cache_id))) {
            if (\Util::isExistInIdStr($id_str, $id, $delimiter)) {
                $id_str = \Util::removeIdFromIdStr($id_str, $id, $delimiter);
                return Cache::put($cache_id, $id_str, $expire);
            }
        }
        return false;
    }

    /**
     * 移除Id串的缓存,单纯用户维护ID类型的串
     */
    public static function replaceId($cache_id, $dict, $expire=1440, $delimiter=',') {
        $from = $dict['from'];
        $to = $dict['to'];
        if(false !== ($id_str = Cache::get($cache_id))) {
            if (\Util::isExistInIdStr($id_str, $from, $delimiter)) {
                $id_str = \Util::replaceIdFromIdStr($id_str, $from, $to, $delimiter);
                return Cache::put($cache_id, $id_str, $expire);
            } else {
                return Cache::pull($cache_id);
            }
        }
        return false;
    }

    /**
     * 把一个id挪到前头
     */
    public static function forwardId($cache_id, $id, $expire=1440, $delimiter=',') {
        if(false !== ($id_str = Cache::get($cache_id))) {
            $id_str = \Util::forwardIdInIdstr($id_str, $id, $delimiter);
            return Cache::put($cache_id, $id_str, $expire);
        }
        return false;
    }
}
