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

    /** @var mixed */
    public $phpDefault;

    public function __construct(string $name, ?string $doc, AvroTypeInterface $type, $default) {
        $this->name = $name;
        $this->doc = $doc;
        $this->type = $type;
        $this->default = $default;
        $this->phpType = $this->type->getPhpType();
        $this->phpDocType = $this->type->getPhpDocType();
        $this->phpDefault = $this->configurePhpDefault();
    }

    private function configurePhpDefault() {
        $default = $this->default;

        switch (gettype($default)) {
            case 'string':
                return "\"$default\"";
            case 'boolean':
                return $default === true ? 'true' : 'false';
            case 'object':
                return null;
            default:
                return $default;
        }
    }

    public static function create(\stdClass $field, ?string $namespace = null): AvroField {
        $type = AvroTypeFactory::create($field->type, $namespace);
        return new AvroField($field->name, $field->doc ?? null, $type, $field->default ?? null);
    }

}