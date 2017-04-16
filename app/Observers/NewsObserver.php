<?php

namespace App\Observers;


use App\Models\News;
use Illuminate\Support\Facades\Log;

class NewsObserver
{
    public function created(News $news) {
        Log::info('a news is created !');
    }
}
