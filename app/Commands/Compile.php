<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Compile extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'compile';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Compile a directory of Avro .avsc files into typed PHP classes.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Compiling...');
    }

}
