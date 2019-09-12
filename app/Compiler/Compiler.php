<?php

namespace App\Compiler;

use App\Compiler\Avro\AvroRecord;
use App\Compiler\Avro\AvroTypeFactory;
use App\Compiler\Twig\TemplateEngine;
use App\Util\Utils;
use Illuminate\Support\Facades\Log;

class Compiler
{

    /**
     * Main compilation function. Takes an input directory with Avro .avsc files and outputs the compiled PHP classes into the output directory.
     * @param string $sourceDir
     * @param string $outDir
     * @param string [$namespace=null] - Defaults to the basename of the output folder.
     * @param bool [$dryRun=false]
     */
    public function compile(string $sourceDir, string $outDir, string $namespace = null, bool $dryRun = false): void
    {

        $outDir = Utils::ensureDir($outDir);
        $namespace = $namespace ?: $this->directoryToNamespace($outDir);

        // Find all avsc files.
        $avscFiles = Utils::find($sourceDir, '/.*\.avsc$/');

        // Copy BaseRecord
        $baseRecord = $this->compileBaseRecord($namespace);
        $path = Utils::joinPaths($outDir, 'BaseRecord.php');
        if ($dryRun) {
            Log::info('(Dry-Run) Compiling base record.', ['path' => $path]);
        } else {
            file_put_contents($path, $baseRecord);
        }

        // Compile each avsc file.
        foreach ($avscFiles as $avscFile) {
            $record = $this->parseRecord($avscFile);

            $compiledPath = Utils::joinPaths($outDir, $record->getCompilePath());

            if ($dryRun) {
                Log::info('(Dry-Run) Compiling file.', ['file' => $record->name, 'compiledPath' => $compiledPath]);
            } else {
                Utils::ensureDir($compiledPath);
                file_put_contents($compiledPath, $this->compileRecord($record, $namespace));
            }
        }

    }

    public function compileFile(string $avscFile, string $namespace): string
    {
        $record = $this->parseRecord($avscFile);
        return $this->compileRecord($record, $namespace);
    }

    public function compileRecord(AvroRecord $record, string $namespace): string
    {
        return $this->templateEngine()->renderRecord($record, $namespace);
    }

    public function compileBaseRecord(string $namespace): string
    {
        return $this->templateEngine()->renderBaseRecord($namespace);
    }

    private function parseRecord(string $avscPath): AvroRecord
    {
        $avsc = file_get_contents($avscPath);
        //TODO: Also parse an avro enum
        return AvroRecord::parse($avsc);
    }

    private function templateEngine(): TemplateEngine
    {
        return (new TemplateEngine());
    }

    private function directoryToNamespace(string $directory): string {
        $namespace = basename($directory);
        $namespace = str_replace('_', '|', $namespace);
        $namespace = str_replace('-', '|', $namespace);
        $namespace = str_replace('|', '', ucwords($namespace, '|'));
        return $namespace;
    }

}
