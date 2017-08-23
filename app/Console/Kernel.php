<?php

namespace App\Console;

use App\Console\Commands\MasterPassStats;
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
        MasterPassStats::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        try {

            $schedule->command('masterpass:stats')->cron('*/30 8-20 * * 1-5');

            $tasks = Notification::all();
            foreach ($tasks as $task) {
                $schedule->call(function () use ($task) {
                    Event::fire(new NotifyUsers($task->receiver, $task->message));
                })
                    ->cron($task->cron);

            }
        } catch (\Exception $e) {
            echo __CLASS__ . PHP_EOL;
            die($e->getMessage());
        }
    }
}
