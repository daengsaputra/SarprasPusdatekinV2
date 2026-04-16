<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\CustomDbCommand::class,

        
    ];

    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        // ...
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
