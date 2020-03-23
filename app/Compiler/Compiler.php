<?php

namespace AvroToPhp\Compiler;

use AvroToPhp\Compiler\Avro\AvroEnum;
use AvroToPhp\Compiler\Avro\AvroNameInterface;
use AvroToPhp\Compiler\Avro\AvroRecord;
use AvroToPhp\Compiler\Avro\AvroTypeFactory;
use AvroToPhp\Compiler\Avro\AvroTypeInterface;
use AvroToPhp\Compiler\Errors\NotImplementedException;
use AvroToPhp\Compiler\Twig\TemplateEngine;
use AvroToPhp\Util\Utils;
use Illuminate\Support\Facades\Log;

class Compiler
{

    /**
     * Main compilation function. Takes an input directory with Avro .avsc files and outputs the compiled PHP classes into the output directory.
     * @param string $sourceDir
     * @param string $outDir
     * @param string [$namespace=null] - Defaults to the basename of the output folder.
     * @param bool [$dryRun=false]
     * @throws
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
            $type = $this->parseFile($avscFile);

            $compiledPath = Utils::joinPaths($outDir, $type->getCompilePath());

            if ($dryRun) {
                Log::info('(Dry-Run) Compiling file.', ['file' => $avscFile, 'compiledPath' => $compiledPath]);
            } else {
                Utils::ensureDir($compiledPath);
                file_put_contents($compiledPath, $this->renderNamedType($type, $namespace));
            }
        }

    }

    public function compileFile(string $avscFile, string $namespace): string
    {
        $type = $this->parseFile($avscFile);
        return $this->renderNamedType($type, $namespace);
    }

    public function renderNamedType(AvroNameInterface $type, string $namespace): string
    {
        if ($type instanceof AvroRecord) {
            return $this->templateEngine()->renderRecord($type, $namespace);
        } else if ($type instanceof AvroEnum) {
            return $this->templateEngine()->renderEnum($type, $namespace);
        } else {
            throw new NotImplementedException('Rendering not implemented for type.');
        }
    }

    public function compileBaseRecord(string $namespace): string
    {
        return $this->templateEngine()->renderBaseRecord($namespace);
    }

    private function parseFile(string $avscPath): AvroNameInterface
    {
        $avsc = file_get_contents($avscPath);
        $typeRaw = json_decode($avsc);
        return AvroTypeFactory::createNamedType($typeRaw);
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
