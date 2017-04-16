<?php
namespace App\Models;

use App\Events\NewSaved;
use App\Events\NewsCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class News extends Model
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
    protected $events = [
        //'saved' => NewSaved::class,
        'created' => NewsCreated::class,
        //'deleted' => UserDeleted::class,
    ];
    
    public function __construct(array $attributes = [])
    {
          //$this->attributes['id'] = '';
          $this->attributes['title'] = '';
          $this->attributes['content'] = '';
          $this->attributes['user_id'] = 0;
          $this->attributes['status'] = 0;
          $this->attributes['created_at'] = '';
          $this->attributes['updated_at'] = '';

        parent::__construct($attributes);

        /*static::created(function ($news) {
            Log::info('New ID:'. $news->id. ' is created, I am in News construct ...');
        });*/
    }

    public function getStatusStrAttribute () {
        return '成功';
    }
}
