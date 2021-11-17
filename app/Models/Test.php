<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Test extends ModelBase
{
    use HasFactory;

    protected $table = 'test';

    public function __construct(array $attributes = [])
    {
        parent::__construct();

        $this->attributes['name'] = '';
    }

    public static function boot() {
        parent::boot();

        self::created(function ($model) {
            Log::info(__METHOD__. "->created model_id:{$model->id}");
        });

        self::saving(function ($model) {
            Log::info(__METHOD__. "->saving model_id:{$model->id}");
        });

        self::saved(function ($model) {
            Log::info(__METHOD__. "->saved model_id:{$model->id}");
        });

        self::updated(function ($model) {
            Log::info(__METHOD__. "->updated model_id:{$model->id}");
        });

        self::deleted(function ($model) {
            Log::info(__METHOD__. "->deleted model_id:{$model->id}");
        });
    }
}
