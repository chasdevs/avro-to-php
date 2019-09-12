<?php


namespace App\Compiler\Twig;


use App\Compiler\Avro\AvroEnum;
use App\Compiler\Avro\AvroRecord;
use Illuminate\Support\Str;
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

    public function renderRecord(AvroRecord $record, string $namespace): string
    {
        $twig = $this->configureRecordTemplate();
        return $twig->render(['namespace' => $namespace, 'record' => $record]);
    }

    public function renderEnum(AvroEnum $enum, string $namespace): string
    {
        $twig = $this->configureEnumTemplate();
        return $twig->render(['namespace' => $namespace, 'enum' => $enum]);
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

    private function configureEnumTemplate(): TemplateWrapper {
        $twig = $this->configureTwig();
        $template = $twig->load('enum.twig');
        return $template;
    }

    private function configureTwig(): Environment {
        $loader = new FilesystemLoader(__DIR__ . '/templates');
        $twig = new Environment($loader);
        $twig->addFilter(new TwigFilter('ucFirst', 'ucFirst'));
        $twig->addFilter(new TwigFilter('spinal', function ($string) {
            return preg_replace('/_/', '-', Str::snake($string));
        }));
        return $twig;
    }
}