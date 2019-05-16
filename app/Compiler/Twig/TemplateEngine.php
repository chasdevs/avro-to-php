<?php


namespace App\Compiler\Twig;


use App\Compiler\Avro\AvroRecord;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;
use Twig\TwigFilter;

class TemplateEngine
{

    public function renderBaseRecord(string $namespace): string
    {
        $twig = $this->configureBaseRecordTemplate();
        return $twig->render(['namespace' => $namespace]);
    }

    public function renderRecord(AvroRecord $record): string
    {
        $twig = $this->configureRecordTemplate();
        return $twig->render(['record' => $record]);
    }

    private function configureBaseRecordTemplate(): TemplateWrapper {
        $twig = $this->configureTwig();
        $template = $twig->load('baseRecord.twig');
        return $template;
    }

    private function configureRecordTemplate(): TemplateWrapper {
        $twig = $this->configureTwig();
        $template = $twig->load('record.twig');
        return $template;
    }

    private function configureTwig(): Environment {
        $loader = new FilesystemLoader(__DIR__ . '/templates');
        $twig = new Environment($loader);
        $twig->addFilter(new TwigFilter('ucFirst', 'ucFirst'));
        return $twig;
    }
}