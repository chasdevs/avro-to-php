<?php 

namespace App\Compiler;

use App\Compiler\Avro\AvroRecord;
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

        // Find all avsc files.
        $avscFiles = Utils::find($sourceDir, '/.*\.avsc$/');

        // Copy BaseRecord
        $baseRecordFile = Utils::resolve(__DIR__, '../BaseRecord.php');
        $baseRecord = file_get_contents($baseRecordFile);
        file_put_contents(Utils::joinPaths($outDir, basename($baseRecordFile)), $baseRecord);

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
        $loader = new FilesystemLoader(__DIR__ . '/templates');
        $twig = new Environment($loader);
        $twig->addFilter(new TwigFilter('ucFirst', 'ucFirst'));
        $template = $twig->load('record.twig');
        return $template;
    }
}