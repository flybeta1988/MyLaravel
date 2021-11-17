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
        if(!is_null($id_str = Cache::get($cache_id)) || $always_add) {
            $id_str = $id_str ? $id_str : '';
            if (!self::isExistInIdStr($id_str, $id, $delimiter)) {
                $id_str = self::addIdToIdStr($id_str, $id, $_reverse=false, $delimiter);
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
        if(!is_null($id_str = Cache::get($cache_id))) {
            if (self::isExistInIdStr($id_str, $id, $delimiter)) {
                $id_str = self::removeIdFromIdStr($id_str, $id, $delimiter);
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
        if(!is_null($id_str = Cache::get($cache_id))) {
            if (self::isExistInIdStr($id_str, $from, $delimiter)) {
                $id_str = self::replaceIdFromIdStr($id_str, $from, $to, $delimiter);
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
        if(!is_null($id_str = Cache::get($cache_id))) {
            $id_str = self::forwardIdInIdstr($id_str, $id, $delimiter);
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

    public static function replaceIdFromIdStr($id_str, $oldId, $newId, $delimiter) {
        $id_str = $delimiter . $id_str . $delimiter;
        return trim(str_replace("{$delimiter}{$oldId}{$delimiter}", "{$delimiter}{$newId}{$delimiter}", $id_str), $delimiter);
    }

    public static function isExistInIdStr($id_str, $id, $delimiter = ',') {
        $id_str = $delimiter . $id_str . $delimiter;
        return strpos($id_str, "{$delimiter}{$id}{$delimiter}") !== false;
    }

    /**
     * 支持最大长度的将一个id添加到一个id_str
     */
    public static function addIdToIdStr($id_str, $id, $reverse = false, $delimiter = ',', $maxlen = 50000) {
        if ($reverse) {
            $id_str = $id_str ? $id_str . $delimiter . $id : $id;
            if (strlen($id_str) > $maxlen) {
                return substr($id_str, strpos($id_str, $delimiter) + 1);
            }
        } else {
            $id_str = $id_str ? $id . $delimiter . $id_str : $id;
            if (strlen($id_str) > $maxlen) {
                return substr($id_str, 0, strrpos($id_str, $delimiter));
            }
        }
        return $id_str;
    }

    public static function forwardIdInIdstr($id_str, $id, $delimiter = ',') {
        if (self::isExistInIdStr($id_str, $id, $delimiter)) {
            $id_str = self::removeIdFromIdStr($id_str, $id, $delimiter);
        }
        return self::addIdToIdStr($id_str, $id, $_reverse = false, $delimiter);
    }

    public static function removeIdFromIdStr($id_str, $id, $delimiter = ',') {
        $id_str = $delimiter . $id_str . $delimiter;
        return trim(str_replace("{$delimiter}{$id}{$delimiter}", $delimiter, $id_str), $delimiter);
    }

    public static function getExpire($value, $expire=0) {
        if (!$value) {
            return CacheConstant::SHORT_EXPIRE_TIME_SECONDS;
        }

        if ($expire <= 0 || $expire >= CacheConstant::LONG_EXPIRE_TIME_SECONDS) {
            return 3600 * rand(24, 72);
        }

        return $expire;
    }
}
