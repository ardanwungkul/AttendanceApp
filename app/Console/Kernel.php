<?php

namespace App\Console;

use App\Models\Pengaturan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $pengaturan = Pengaturan::first();
        $schedule->command('check:user-absence')
            ->weekdays()
            ->at($pengaturan->batas_waktu);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
