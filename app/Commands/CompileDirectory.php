<?php

namespace AvroToPhp\Commands;

use AvroToPhp\Compiler\Compiler;
use AvroToPhp\Util\Utils;
use LaravelZero\Framework\Commands\Command;

class CompileDirectory extends Command
{

    protected $signature = 'compile {directory} {outputDirectory=./compiled} {--d|dry-run} {--namespace=}';

    protected $description = 'Compile a directory containing Avro .avsc files to PHP classes.';

    public function handle(Compiler $compiler)
    {
        $sourceDir = $this->argument('directory');
        $outputDir = $this->argument('outputDirectory');
        $dryRun = $this->option('dry-run');
        $namespace = $this->option('namespace');

        $source = Utils::resolve($sourceDir);
        if (!$source) {
            throw new \RuntimeException('Could not find directory: '.$sourceDir);
        }

        $this->comment('Compiling Avro files in ' . $source . ' to ' . $outputDir . ($namespace ? " using namespace $namespace" : '') . ($dryRun ? ' (Dry-Run)' : ''));
        $compiler->compile($source, $outputDir, $namespace, $dryRun);
        $this->comment('Done!');
    }

}
