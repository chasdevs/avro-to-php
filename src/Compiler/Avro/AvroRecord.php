<?php

namespace AvroToPhp\Compiler\Avro;

use AvroToPhp\Compiler\Errors\NotImplementedException;

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

    public function __construct(string $namespace, string $name, string $doc, array $fields, string $schema)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->doc = $doc;
        $this->fields = $fields;
        $this->schema = $schema;
    }

    /**
     * @param string $json
     * @return AvroRecord
     * @throws NotImplementedException
     */
    public static function parse(string $json): AvroRecord
    {
        $decoded = json_decode($json);

        if ($decoded->order) {
            throw new NotImplementedException('order field not implemented in compiler.');
        }

        if ($decoded->aliases) {
            throw new NotImplementedException('aliases field not implemented in compiler.');
        }

        $fields = array_map(function (\stdClass $field) {
            return AvroField::fromStdClass($field);
        }, $decoded->fields);

        return new self($decoded->namespace, $decoded->name, $decoded->doc, $fields, $json);
    }

}