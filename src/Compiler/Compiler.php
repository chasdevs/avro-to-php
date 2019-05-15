<?php 

namespace AvroToPhp\Compiler;

use AvroToPhp\Compiler\Avro\AvroRecord;
use AvroToPhp\Util\Utils;
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

        // Find all avsc files.
        $avscFiles = Utils::find($sourceDir, '/.*\.avsc$/');

        // Compile each avsc file.
        foreach ($avscFiles as $avscFile) {
            $record = $this->parseRecord($avscFile);

            $compiledPath = Utils::joinPaths($outDir, $record->getCompilePath());

            //TODO: dry-run
            Utils::ensureDir($compiledPath);
            file_put_contents($compiledPath, $this->recordToPhp($record));
        }

    }

    public function compileFile(string $avscFile): string {
        $record = $this->parseRecord($avscFile);
        return $this->recordToPhp($record);
    }

    public function recordToPhp(AvroRecord $record): string
    {
        $twig = $this->configureTwig();
        return $twig->render(['record' => $record]);
    }

    public function parseRecord(string $avscPath): AvroRecord {
        $avsc = file_get_contents($avscPath);
        return AvroRecord::parse($avsc);
    }

    private function configureTwig(): TemplateWrapper {
        $loader = new FilesystemLoader(__DIR__.'/templates');
        $twig = new Environment($loader);
        $twig->addFilter(new TwigFilter('ucFirst', 'ucFirst'));
        $template = $twig->load('record.twig');
        return $template;
    }
}