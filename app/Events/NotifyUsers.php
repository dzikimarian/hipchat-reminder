<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyUsers extends Event
{
    use SerializesModels;
	
	public $text;
	public $receiver;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($receiver, $text)
    {
		$this->text = $text;
		$this->receiver = $receiver;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
