<?php
namespace App\ModelCache;

use App\Library\Cache\CacheUtil;
use App\ModelInterface\NewsInterface;

class NewsCache implements NewsInterface
{
    public static function getGt25IdList()
    {
        return __METHOD__;
    }

    public static function maintain($rowObj, $type, $expire = 1440)
    {
        $cacheId = self::getGt25IdList();
        CacheUtil::maintain($cacheId, $rowObj->id, $type, $expire);
    }
}
