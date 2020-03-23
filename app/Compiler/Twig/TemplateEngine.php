<?php


namespace AvroToPhp\Compiler\Twig;


use AvroToPhp\Compiler\Avro\AvroEnum;
use AvroToPhp\Compiler\Avro\HasName;
use AvroToPhp\Compiler\Avro\AvroRecord;
use AvroToPhp\Compiler\Avro\AvroTypeInterface;
use AvroToPhp\Util\Utils;
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
        $twig->addFilter(new TwigFilter('assoc', [$this, 'renderAssociativeArray']));
        return $twig;
    }

    public function renderAssociativeArray($array, $indent = 4, $pad = 4): string {
        if (is_array($array)) {
            $string = "[";
            foreach($array as $key => $value) {
                $value = $this->renderAssociativeArray($value, $indent + 4);
                if ($indent) {
                    $start = PHP_EOL . $this->indent($pad + $indent);
                    $end = array_key_last($array) == $key ? '' : ',';
                } else {
                    $start = array_key_first($array) == $key ? '' : ' ';
                    $end = ",";
                }
                $string .= "$start\"$key\" => $value$end";
            }
            $string .= $indent ? PHP_EOL . $this->indent($pad + $indent - 4) . "]" : "]";
            return $string;
        } else {
            return Utils::renderPhpDefault($array);
        }
    }

    private function indent($spaces) {
        return implode("", array_map(function () { return " "; }, range(1, $spaces)));
    }
}