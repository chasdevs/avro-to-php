<?php

namespace App\Commands;

use App\Compiler\Compiler;
use App\Util\Utils;
use LaravelZero\Framework\Commands\Command;

class CompileDirectory extends Command
{

    protected $signature = 'compile:directory {directory} {outputDirectory=./compiled} {--d|dry-run}';

    protected $description = 'Compile a directory containing Avro .avsc files to PHP classes.';

    public function handle(Compiler $compiler)
    {
        $sourceDir = $this->argument('directory');
        $outputDir = $this->argument('outputDirectory');
        $dryRun = $this->option('dry-run');

        $source = Utils::resolve($sourceDir);


        $this->comment('Compiling Avro files in ' . $source . ' to ' . $outputDir . ($dryRun ? ' (Dry-Run)' : ''));
        $compiler->compile($source, $outputDir, $dryRun);
        $this->comment('Done!');
    }

}
