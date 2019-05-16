<?php

namespace App\Commands;

use App\Compiler\Compiler;
use App\Util\Utils;
use LaravelZero\Framework\Commands\Command;

class CompileDirectory extends Command
{

    protected $signature = 'compile:directory {directory} {outputDirectory?}';

    protected $description = 'Compile a directory containing Avro .avsc files to PHP classes.';

    public function handle(Compiler $compiler)
    {
        $sourceDir = $this->argument('directory');
        $outputDir = $this->argument('outputDirectory');

        $source = Utils::resolve($sourceDir);
        $target = Utils::resolve($outputDir);

        $this->comment('Compiling Avro files in ' . $source . ' to ' . $target . '.');
        $compiler->compile($source, $target);
        $this->info('Done!');
    }

}
