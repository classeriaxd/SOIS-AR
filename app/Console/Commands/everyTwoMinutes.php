<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class everyTwoMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twoMinute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Run 10 jobs every two minutes';

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
     * @return int
     */
    public function handle()
    {
        Artisan::call('queue:work --max-jobs=10 --stop-when-empty');
        Artisan::call('queue:retry all');
    }
}
