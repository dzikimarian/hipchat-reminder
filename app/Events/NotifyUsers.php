<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyUsers extends Event
{
    use SerializesModels;
	
	public $channel;
	public $text;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $text)
    {
        $this->channel = $channel;
		$this->text = $text;
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
