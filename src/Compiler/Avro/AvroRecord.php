<?php

namespace AvroToPhp\Compiler\Avro;

use AvroToPhp\Compiler\Errors\NotImplementedException;
use AvroToPhp\Util\Utils;

class AvroRecord implements AvroTypeInterface
{

    /** @var string */
    public $name;

    /** @var string|null */
    public $namespace;

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

    public function __construct(string $name, ?string $namespace, ?string $doc, array $fields, string $schema)
    {
        $this->name = $name;
        $this->namespace = $namespace;
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
            if ($field->ref) {
                $imports[] = $field->ref->getQualifiedPhpType();
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

    public function getPhpType(): string
    {
        return $this->name;
    }

    public function getPhpDocType(): string
    {
        return $this->getPhpType();
    }

    public static function parse(string $json): AvroRecord
    {
        $decoded = json_decode($json);
        return self::create($decoded, $json);
    }

    public static function create(\stdClass $record): AvroRecord {
        if ($record->order) {
            throw new NotImplementedException('order field not implemented in compiler.');
        }

        if ($record->aliases) {
            throw new NotImplementedException('aliases field not implemented in compiler.');
        }

        $fields = array_map(function (\stdClass $field) {
            return AvroField::create($field);
        }, $record->fields);

        return new self($record->name, $record->namespace, $record->doc, $fields, json_encode($record, JSON_PRETTY_PRINT));
    }
}