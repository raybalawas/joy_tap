<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
     protected $commands = [
        Commands\AutoGroupDeleteCommand::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('auto-delete-groups:cron')
        ->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
