<?php
namespace App\Models;

use App\Events\NewSaved;
use App\Events\NewsCreated;
use App\Events\NewsSavedEvent;
use App\Events\NewsUpdated;
use App\Library\Cache\CacheMaintainType;
use App\Library\Cache\CacheUtil;
use App\ModelCache\NewsCache;
use App\Observers\NewsObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class News extends XnwModel
{
    protected $table = "news";

    //白名单
    protected $fillable = [
        'title',
        'content',
    ];

    //黑名单
    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
/*    protected $events = [
        'saving' => NewSaved::class,
        'saved' => NewSaved::class,
        'created' => NewsCreated::class,
        'updated' => NewsUpdated::class,
        //'deleted' => UserDeleted::class,
    ];*/

/*    protected $observables = [
        'saved' => NewsSavedEvent::class
    ];*/
    
    public function __construct(array $attributes = [])
    {
          //$this->attributes['id'] = '';
          $this->attributes['title'] = '';
          $this->attributes['content'] = '';
          $this->attributes['user_id'] = 0;
          $this->attributes['status'] = 0;
          $this->attributes['ctime'] = '';
          $this->attributes['utime'] = '';

        parent::__construct($attributes);

    }

    public function getStatusStrAttribute () {
        return '成功';
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'nid', 'id');
    }

    public static function maintainCache($rowObj, $type, $expire = 1440)
    {
        NewsCache::maintain($rowObj, $type, $expire);
    }

    public static function getHotIdList () {
        return $cache_id = __METHOD__;
        $id_str = self::select(
            DB::raw('GROUP_CONCAT(id) AS id_str')
        )->where('id', '<', 5)->value('id_str');
        return explode(',', $id_str);
    }
}
