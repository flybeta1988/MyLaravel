<?php

namespace App\Listeners;

use App\Events\NewsSavedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NewsSavedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewsSavedEvent  $event
     * @return void
     */
    public function handle(NewsSavedEvent $event)
    {
        Log::info(__CLASS__. ' is work !');
    }
}
