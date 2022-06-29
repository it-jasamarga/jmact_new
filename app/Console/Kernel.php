<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CronOvertimeNotification::class,
        Commands\CronCloseFeedback::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
/* lines to add vie "crontab -e"
# JMACT
0 8 * * * /usr/bin/php /var/www/html/JMACT-NEW/artisan cron:overtime:notification > /dev/null 2>&1
0 1 * * * /usr/bin/php /var/www/html/JMACT-NEW/artisan cron:close:feedback > /dev/null 2>&1
*/
        $schedule->command('cron:overtime:notification')->dailyAt('08:00');
        $schedule->command('cron:close:feedback')->dailyAt('01:00');
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
