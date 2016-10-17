<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HipChatRequest extends Request
{
    public $hipChatData;
	
	function __construct()
	{
		parent::__construct();
		
		$this->hipChatData = json_decode($this->getContent());		
	}
	
	public function getMentionNames()
	{
		
		$mentions = collect($this->hipChatData->item->message->mentions);
		
		return $mentions->map(function($item, $key){
			return $item->mention_name;
		});
		
	}
	
	public function getRoomName()
	{
		return $this->hipChatData->item->room->name;
	}
	
	public function getSenderName()
	{
		return $this->hipChatData->item->message->from->name;
	}
}
