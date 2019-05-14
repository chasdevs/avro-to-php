<?php

namespace AvroToPhp\Compiler\Avro;

class AvroField {
    /** @var string */
    public $name;

    /** @var string|null */
    public $doc;

    /** @var AvroType */
    public $type;

    /** @var string|int|float| */
    public $phpType;

    /** @var mixed|null */
    public $default;

    /** @var AvroRecord|null */
    public $record;

    public function __construct(string $name, ?string $doc, AvroType $type, $default, ?AvroRecord $record) {
        $this->name = $name;
        $this->doc = $doc;
        $this->type = $type;
        $this->default = $default;
        $this->record = $record;
        $this->configurePhpType();
    }

    private function configurePhpType() {
        $recordType = $this->record ? $this->record->name : null;
        $this->phpType = $this->type->getPhpType($recordType);
    }

    public static function fromStdClass(\stdClass $field): AvroField {
        $record = null;
        $type = null;

        if (is_object($field->type)) {
            $record = AvroRecord::fromStdClass($field->type);
            $type = AvroType::RECORD();
        }

        return new self($field->name, $field->doc, $type ?: new AvroType($field->type), $field->default, $record);
    }
}