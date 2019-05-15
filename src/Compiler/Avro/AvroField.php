<?php

namespace AvroToPhp\Compiler\Avro;

class AvroField {

    /** @var string */
    public $name;

    /** @var string|null */
    public $doc;

    /** @var  AvroTypeInterface */
    public $type;

    /** @var string */
    public $phpType;

    /** @var mixed|null */
    public $default;

    public function __construct(string $name, ?string $doc, AvroTypeInterface $type, $default) {
        $this->name = $name;
        $this->doc = $doc;
        $this->type = $type;
        $this->default = $default;
        $this->configurePhpType();
    }

    private function configurePhpType() {
        $this->phpType = $this->type->getPhpType();
    }

    public static function create(\stdClass $field): AvroField {
        $type = AvroTypeFactory::create($field->type);
        return new AvroField($field->name, $field->doc, $type, $field->default);
    }

}