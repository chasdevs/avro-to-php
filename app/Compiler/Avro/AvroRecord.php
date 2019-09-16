<?php

namespace App\Compiler\Avro;

use App\Compiler\Errors\NotImplementedException;
use App\Util\Utils;

class AvroRecord implements AvroTypeInterface, AvroNameInterface
{

    use HasName;

    /** @var string */
    public $doc;

    /** @var AvroField[] */
    public $fields;

    /** @var string */
    public $schema;

    /** @var string[] */
    public $imports = [];

    /** @var string[] */
    public $aliases;

    public function __construct(string $name, ?string $namespace, ?string $doc, array $fields, string $schema, ?array $aliases)
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->doc = $doc;
        $this->fields = $fields;
        $this->schema = $schema;
        $this->aliases = $aliases;
        $this->configurePhpNamespace();
        $this->configureImports();
    }

    private function configureImports() {
        foreach($this->fields as $field) {
            $this->imports += $field->type->getImports();
        }
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
        return self::create($decoded);
    }

    public static function create(\stdClass $record): AvroRecord {
        if (isset($record->order)) {
            throw new NotImplementedException('order field not implemented in compiler.');
        }

        $fields = array_map(function (\stdClass $field) {
            return AvroField::create($field);
        }, $record->fields);

        return new self($record->name, $record->namespace ?? null, $record->doc ?? null, $fields, json_encode($record, JSON_PRETTY_PRINT), $record->aliases ?? null);
    }

    public function getType(): AvroType
    {
        return AvroType::RECORD();
    }

    public function getImports(): array
    {
        return [$this->getQualifiedPhpType()];
    }
}