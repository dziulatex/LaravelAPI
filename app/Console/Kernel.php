<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Integrations\APIusersintegration;
use App\Integrations\APIpostsintegration;
use Illuminate\Support\Facades\Storage;
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
        $schedule->call(function ()
        {
            $users=new APIusersintegration();
            $users->set('url','https://jsonplaceholder.typicode.com/users');
            $json=$users->fetchFromAPI();
            $users->whatToUpdateAndInsert($json);
            $users->insertOrUpdateUsers($json);
            if (!empty($users->exceptions)) {
                Log::warning(print_r($users->exceptions, true));
            }
            $posts=new APIpostsintegration();
            $posts->set('url','https://jsonplaceholder.typicode.com/posts');
            $json=$posts->fetchFromAPI();
            $posts->whatToUpdateAndInsert($json);
            $posts->insertOrUpdatePosts($json);
            if (!empty($posts->exceptions)) {
                Log::warning(print_r($posts->exceptions, true));
            }
            $logs='POSTS: '.print_r($posts->exceptions, true).' USERS: '.print_r($users->exceptions, true);
            Storage::append('logs/ApisLogs.log',$logs);
        })->cron('5 2 * * *');
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
