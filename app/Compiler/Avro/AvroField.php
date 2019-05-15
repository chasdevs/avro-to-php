<?php

namespace App\Compiler\Avro;

class AvroField {

    /** @var string */
    public $name;

    /** @var string|null */
    public $doc;

    /** @var  AvroTypeInterface */
    public $type;

    /** @var string */
    public $phpType;

    /** @var string */
    public $phpDocType;

    /** @var mixed|null */
    public $default;

    public function __construct(string $name, ?string $doc, AvroTypeInterface $type, $default) {
        $this->name = $name;
        $this->doc = $doc;
        $this->type = $type;
        $this->default = $default;
        $this->phpType = $this->type->getPhpType();
        $this->phpDocType = $this->type->getPhpDocType();
    }

    public static function create(\stdClass $field): AvroField {
        $type = AvroTypeFactory::create($field->type);
        return new AvroField($field->name, $field->doc ?? null, $type, $field->default ?? null);
    }

}