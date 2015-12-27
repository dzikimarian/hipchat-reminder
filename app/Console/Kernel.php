<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Event;
use App\Events\NotifyUsers;
use App\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $tasks = Notification::all();
		
		foreach($tasks as $task) {
		
			$schedule->call(function() use ($task){ Event::fire(new NotifyUsers('hipchat', $task->message)); })
                ->cron($task->cron);
		}
    }
}
