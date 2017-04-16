<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comment";

    //白名单
    protected $fillable = [
        'content',
        'nid',
    ];

    public function news()
    {
        return $this->belongsTo('App\Models\News', 'nid');
    }
}
