<?php

namespace AvroToPhp\Commands;

use AvroToPhp\Compiler\Compiler;
use AvroToPhp\Util\Utils;
use LaravelZero\Framework\Commands\Command;

class CompileFile extends Command
{

    protected $signature = 'compile:file {file} {outputDirectory=.} {--p|print} {--namespace=}';

    protected $description = 'Compile an Avro .avsc files into a typed PHP class.';

    public function handle(Compiler $compiler)
    {
        $fileArg = $this->argument('file');
        $outputDir = $this->argument('outputDirectory');
        $print = $this->hasOption('p');
        $namespace = $this->option('namespace');
        $namespace = $namespace ?: Compiler::directoryToNamespace($outputDir);

        $this->comment('Compiling Avro schema to PHP: ' . $fileArg . ($namespace ? " using namespace $namespace" : ''));

        $file = Utils::resolve($fileArg);
        $compiled = $compiler->compileFile($file, $namespace);

        if ($print) {
            $this->comment('Compiler output:');
            $this->info($compiled);
        } else {
            $fileName = pathinfo($fileArg, PATHINFO_FILENAME);
            $path = Utils::joinPaths($outputDir, $fileName.'.php');
            file_put_contents($path, $compiled);
            $this->comment('Compiled PHP class: '.$path);
        }
    }

}
