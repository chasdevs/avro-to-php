<?php

namespace App\Commands;

use App\Compiler\Compiler;
use App\Util\Utils;
use LaravelZero\Framework\Commands\Command;

class Compile extends Command
{

    protected $signature = 'compile:file {file} {outputDirectory=.} {--p|print}';

    protected $description = 'Compile an Avro .avsc files into a typed PHP class.';

    public function handle(Compiler $compiler)
    {
        $fileArg = $this->argument('file');
        $outputDir = $this->argument('outputDirectory');
        $print = $this->hasOption('p');

        $this->comment('Compiling Avro schema to PHP: ' . $fileArg);

        $file = Utils::resolve($fileArg);
        $compiled = $compiler->compileFile($file);

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
