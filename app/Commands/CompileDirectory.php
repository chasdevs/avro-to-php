<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class CompileDirectory extends Command
{

    protected $signature = 'compile:directory {directory}';

    protected $description = 'Compile a directory containing Avro .avsc files to PHP classes.';

    public function handle()
    {
        $this->error('TODO');
    }

}
