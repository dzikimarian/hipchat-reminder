<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Event;
use App\Events\NotifyUsers;
use App\Notification;

class NotificationsController extends Controller
{
    public function test()
	{
		Event::fire(new NotifyUsers('hipchat', 'HelloWorld!'));
		return "test";
	}
	
	public function addNtf()
	{
		$notification = new Notification();
		
		$notification->message = 'test';
		$notification->cron = '* * * * * *';
		
		$notification->save();
		
		return "added";
	}
}
