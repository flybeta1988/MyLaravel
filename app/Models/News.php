<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";
    
    public function __construct(array $attributes = [])
    {
          $this->attributes['id'] = '';
          $this->attributes['title'] = '';
          $this->attributes['content'] = '';
          $this->attributes['user_id'] = '';
          $this->attributes['status'] = 0;
          $this->attributes['created_at'] = '';
          $this->attributes['updated_at'] = '';

        parent::__construct($attributes);
    }
}
