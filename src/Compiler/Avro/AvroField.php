<?php

namespace AvroToPhp\Compiler\Avro;

use AvroToPhp\Compiler\Errors\NotImplementedException;

class AvroField {
    /** @var string */
    public $name;

    /** @var string|null */
    public $doc;

    /** @var AvroType */
    public $type;

    /** @var string|int|float| */
    public $phpType;

    public $default;

    public function __construct(string $name, ?string $doc, AvroType $type, $default) {
        $this->name = $name;
        $this->doc = $doc;
        $this->type = $type;
        $this->phpType = $this->type->getPhpType();
        $this->default = $default;
    }

    public static function fromStdClass(\stdClass $field): AvroField {
        if (is_object($field->type)) {
            throw new NotImplementedException('Need to implement sub-records');
        }

        return new self($field->name, $field->doc, new AvroType($field->type), $field->default);
    }
}