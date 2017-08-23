<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\HipChatRequest;
use App\Http\Controllers\Controller;
use Event;
use App\Events\NotifyUsers;
use App\Notification;
use App\Receiver;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Collection;
use App\Bots\Summoner;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    public function test()
	{
		$receiver = Receiver::where('type', 'SMS')->firstOrFail();
		Event::fire(new NotifyUsers($receiver, 'HelloWorld!'));
		return "test";
	}

	public function addNtf()
	{
		$notification = new Notification();

		$notification->message = 'test';
		$notification->cron = '* * * * * *';
		$notification->receiver_id = 1;

		$notification->save();

		return "added";
	}

	public function hipChatSummoner(HipChatRequest $request, Summoner $summoner)
	{	
		$mentionNames = $request->getMentionNames();
		$roomName = $request->getRoomName();
		$senderName = $request->getSenderName();
		
		$response = $summoner->summonMentionedUsers($mentionNames, $roomName, $senderName);
		
		return $response;
	}
}
