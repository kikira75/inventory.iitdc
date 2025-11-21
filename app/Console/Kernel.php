<?php

namespace App\Console;

use App\Console\Commands\ImportLocations;
use App\Console\Commands\ReEncodeCustomFieldNames;
use App\Console\Commands\RestoreDeletedUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('snipeit:inventory-alerts')->daily();
        // $schedule->command('snipeit:expiring-alerts')->daily();
        // $schedule->command('snipeit:expected-checkin')->daily();
        // $schedule->command('snipeit:backup')->weekly();
        // $schedule->command('backup:clean')->daily();
        // $schedule->command('snipeit:upcoming-audits')->daily();
        // $schedule->command('auth:clear-resets')->everyFifteenMinutes();
        // $schedule->command('saml:clear_expired_nonces')->weekly();
        // $schedule->command('sg:cronjob-transaksi-pemasukan')->everyFiveMinutes();
        // $schedule->command('sg:cronjob-transaksi-pengeluaran')->everyFiveMinutes();
        // $schedule->command('sg:cronjob-transaksi-stockopname')->everyFiveMinutes();
        // $schedule->command('sg:cronjob-transaksi-adjusment')->everyFiveMinutes();
        $schedule->command('sg:cronjob-transaksi-pemasukan')->hourly();
        $schedule->command('sg:cronjob-transaksi-pengeluaran')->hourly();
        $schedule->command('sg:cronjob-transaksi-stockopname')->hourly();
        $schedule->command('sg:cronjob-transaksi-adjusment')->hourly();
    }

    /**
     * This method is required by Laravel to handle any console routes
     * that are defined in routes/console.php.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
        $this->load(__DIR__.'/Commands');
    }
}
