<?php

/**
 * 维护ID缓存列表工具类
 */

namespace App\Library\Cache;

use Illuminate\Support\Facades\Cache;

class CacheUtil
{
    /**
     * 添加id串的缓存,单纯用于维护ID类型的串
     */
    public static function addId($cache_id, $id, $expire=1440, $delimiter=',', $always_add=false) {
        if(false !== ($id_str = Cache::get($cache_id)) || $always_add) {
            $id_str = $id_str ? $id_str : '';
            if (!\Util::isExistInIdStr($id_str, $id, $delimiter)) {
                $id_str = \Util::addIdToIdStr($id_str, $id, $_reverse=false, $delimiter);
                Cache::put($cache_id, $id_str, $expire);
                return true;
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
                Cache::put($cache_id, $id_str, $expire);
                return true;
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
                Cache::put($cache_id, $id_str, $expire);
                return true;
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
            Cache::put($cache_id, $id_str, $expire);
            return true;
        }
        return false;
    }

    public static function delete($cache_id) {
        return Cache::pull($cache_id);
    }

    public static function maintain($cache_id, $id, $type, $expire=1440, $delimiter=',') {
        switch ($type) {
            case 'add':
                return self::addId($cache_id, $id, $expire, $delimiter);
            case 'remove':
                return self::removeId($cache_id, $id, $expire, $delimiter);
            case 'replace':
                return self::replaceId($cache_id, $id, $expire, $delimiter);
            case 'forward':
                return self::forwardId($cache_id, $id, $expire, $delimiter);
            case 'delete':
                return self::delete($cache_id);
            default:
                return false;
        }
    }

}
