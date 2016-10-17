<?php

namespace App\Listeners;

use App\Events\NotifyUsers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SMSListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  NotifyUsers  $event
     * @return void
     */
    public function handle(NotifyUsers $event)
    {
		if($event->receiver->type!='SMS') return true;
				
		$url = $event->receiver->target . urlencode($event->text);
		file_get_contents($url);
    }
}
