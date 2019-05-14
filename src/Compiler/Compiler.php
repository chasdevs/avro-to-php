<?php 

namespace StoryblocksEvents\Compiler;

use StoryblocksEvents\Compiler\Avro\AvroRecord;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

class Compiler
{
    public function avscFileToPhp(string $filePath): string
    {
        // Parse json from file.
        $avsc = file_get_contents($filePath);
        return $this->compileJson($avsc);
    }

    public function compileJson(string $json): string {
        $record = AvroRecord::parse($json);
        $twig = $this->configureTwig();
        return $twig->render(['record' => $record]);
    }

    private function configureTwig(): TemplateWrapper {
        $loader = new FilesystemLoader(__DIR__.'/templates');
        $twig = new Environment($loader);
        $template = $twig->load('record.twig');
        return $template;
    }
}