<?php

namespace App\Listeners;

use App\Events\NotifyUsers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HipChatListener
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
		if($event->receiver->type!='HipChat') return true;
		
		$url = $event->receiver->target;
		$config = array(
			'color' => 'green',
			'message' => $event->text,
			'notify' => true
		);
		
		$this->postJSON($url, $config);
		
    }
	
	private function postJSON($url, $data){
		$postdata = json_encode($data);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/json',
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$result = file_get_contents($url, false, $context);
	}
}
