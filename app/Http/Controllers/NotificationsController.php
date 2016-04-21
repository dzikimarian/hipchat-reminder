<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Event;
use App\Events\NotifyUsers;
use App\Notification;
use App\Receiver;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends Controller
{
    public function test()
	{
		$receiver = Receiver::where('name', 'Test')->firstOrFail();
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

	public function hipChatWebhook()
	{
		$content = array(
			'color' => 'green',
			'message' => 'wat',
			'notify' => false,
			'mesage_format' => 'text'
		);

		return $content;
	}
}
