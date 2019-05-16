<?php 

namespace App\Compiler;

use App\Compiler\Avro\AvroRecord;
use App\Compiler\Twig\TemplateEngine;
use App\Util\Utils;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;
use Twig\TwigFilter;

class Compiler
{

    /**
     * Main compilation function. Takes an input directory with Avro .avsc files and outputs the compiled PHP classes into the output directory.
     * @param string $sourceDir
     * @param string $outDir
     * @throws \Throwable
     */
    public function compile(string $sourceDir, string $outDir): void {

        $outDir = Utils::ensureDir($outDir);
        $namespace = ucfirst(basename($outDir));

        // Find all avsc files.
        $avscFiles = Utils::find($sourceDir, '/.*\.avsc$/');

        // Copy BaseRecord
        $baseRecord = $this->compileBaseRecord($namespace);
        file_put_contents(Utils::joinPaths($outDir, 'BaseRecord.php'), $baseRecord);

        // Compile each avsc file.
        foreach ($avscFiles as $avscFile) {
            $record = $this->parseRecord($avscFile);

            $compiledPath = Utils::joinPaths($outDir, $record->getCompilePath());

            //TODO: dry-run
            Utils::ensureDir($compiledPath);
            file_put_contents($compiledPath, $this->compileRecord($record, $namespace));
        }

    }

    public function compileFile(string $avscFile, string $namespace): string {
        $record = $this->parseRecord($avscFile);
        return $this->compileRecord($record, $namespace);
    }

    public function compileRecord(AvroRecord $record, string $namespace): string {
        return $this->templateEngine()->renderRecord($record, $namespace);
    }

    public function compileBaseRecord(string $namespace): string {
        return $this->templateEngine()->renderBaseRecord($namespace);
    }

    private function parseRecord(string $avscPath): AvroRecord {
        $avsc = file_get_contents($avscPath);
        return AvroRecord::parse($avsc);
    }

    private function templateEngine(): TemplateEngine {
        return (new TemplateEngine());
    }

}