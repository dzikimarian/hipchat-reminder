<?php

namespace App\Bots;

use App\Receiver;
use Event;
use App\Events\NotifyUsers;
use Illuminate\Support\Collection;

class Summoner
{
	public function summonMentionedUsers($mentionNames, $roomName, $senderName)
	{
	
		$receivers = Receiver::where('type', 'SMS')->whereIn('name', $mentionNames->all())->get();
		
		foreach($receivers as $receiver){
			Event::fire(new NotifyUsers($receiver, $senderName . ' przyzywa Cie na HipChata. Pokoj: ' . $roomName));
		}	
		
		$response = $this->createHipChatResponse($receivers);
				
		return $response;
	}
	
	private function createHipChatResponse($receivers)
	{
		$summoned = $receivers->map(function($item, $key){
			return $item->name;
		})->implode(', ');
		
		$message = 'Przyzwano nastepujące osoby: ' . $summoned;
		
		if($receivers->isEmpty()){
			$message = 'Not enough mana.';
		}
		
		return array(
			'color' => 'green',
			'message' => $message,
			'notify' => false,
			'mesage_format' => 'text'
		);
		
	}
}