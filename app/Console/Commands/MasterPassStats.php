<?php

namespace App\Console\Commands;

use App\Jira\MasterPass\MasterPassUsers;
use Illuminate\Console\Command;

use Event;
use App\Events\NotifyUsers;
use App\Receiver;

class MasterPassStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'masterpass:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(MasterPassUsers $masterPassUsers)
    {
        $freeUsers = $masterPassUsers->getFreeUsers();
        if(count($freeUsers) === 0) {
            $message = 'Wszyscy ostro naginają!';
        } else {
            $message = '@DamianMarzec co robią te ludziki?  ==> ';
            foreach ($freeUsers as $dude) {
                $message.= $dude->key . ' ';
            }
        }
        $receiver = Receiver::where('name', 'MasterPass - powiadomienia')->firstOrFail();
        Event::fire(new NotifyUsers($receiver, $message));


    }
}
