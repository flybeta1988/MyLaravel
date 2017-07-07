<?php
namespace App\ModelMiddle;

use App\Library\Cache\CacheConstant;
use App\ModelCache\NewsCache;
use App\ModelInterface\NewsInterface;
use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NewsMiddle extends News implements NewsInterface
{
    public static function getGt25IdList () {
        $cacheId = NewsCache::getGt25IdList();

        if (Cache::has($cacheId) && ($idStr = Cache::get($cacheId))) {
            ;
        } else {
            $idStr = self::select(
                DB::raw('GROUP_CONCAT(id ORDER BY id DESC) AS id_str')
            )->where('id', '>', 25)->value('id_str');

            Cache::put($cacheId, $idStr, CacheConstant::NORMAL_EXPIRE_TIME_MINUTES);
        }
        $idList = $idStr ? explode(',', $idStr) : [];

        return $idList;
    }
}
