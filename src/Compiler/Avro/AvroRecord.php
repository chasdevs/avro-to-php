<?php

namespace AvroToPhp\Compiler\Avro;

use AvroToPhp\Compiler\Errors\NotImplementedException;
use AvroToPhp\Util\Utils;

class AvroRecord
{

    /** @var string */
    public $namespace;

    /** @var string */
    public $name;

    /** @var string */
    public $doc;

    /** @var AvroField[] */
    public $fields;

    /** @var string */
    public $schema;

    /** @var string */
    public $phpNamespace;

    /** @var string[] */
    public $imports;

    public function __construct(string $namespace, string $name, ?string $doc, array $fields, string $schema)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->doc = $doc;
        $this->fields = $fields;
        $this->schema = $schema;
        $this->configurePhpNamespace();
        $this->configureImports();
    }

    private function configurePhpNamespace() {
        $parts = preg_split('/\./', $this->namespace);
        $newParts = array_map(function (string $p) {
            return ucfirst($p);
        }, $parts);
        $this->phpNamespace = join('\\', $newParts);
    }

    private function configureImports() {
        $imports = [];
        foreach($this->fields as $field) {
            if ($field->record) {
                $imports[] = $field->record->getQualifiedPhpType();
            }
        }
        $this->imports = $imports;
    }

    public function getCompilePath(): string {
        $namespace = preg_replace("/\\\/", DIRECTORY_SEPARATOR, $this->phpNamespace);
        return Utils::joinPaths($namespace, $this->name.'.php');
    }

    public function getQualifiedPhpType(): string {
        return $this->phpNamespace . '\\' . $this->name;
    }

    public static function parse(string $json): AvroRecord
    {
        $decoded = json_decode($json);
        return self::fromStdClass($decoded, $json);
    }

    public static function fromStdClass(\stdClass $record): AvroRecord {
        if ($record->order) {
            throw new NotImplementedException('order field not implemented in compiler.');
        }

        if ($record->aliases) {
            throw new NotImplementedException('aliases field not implemented in compiler.');
        }

        $fields = array_map(function (\stdClass $field) {
            return AvroField::fromStdClass($field);
        }, $record->fields);

        return new self($record->namespace, $record->name, $record->doc, $fields, json_encode($record, JSON_PRETTY_PRINT));
    }

}