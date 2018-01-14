<?php

namespace App\Console;

use App\Account;
use App\Http\Controllers\AdminController;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            //mail('aaditya.span@gmail.com', 'test mail from cron job', 'test mail from cron job');
            Account::where('display', 0)->update(['display'=>1]);
            $ac = new AdminController();
            $ac->member_pv();
            $ac->total_act();
        })->everyMinute();

        $schedule->call(function () {
            $ac = new AdminController();
            $ac->member_level();
        })->weekly()->fridays()->at('01:00');
    }
}
