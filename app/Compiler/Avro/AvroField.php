<?php

namespace App\Compiler\Avro;

use App\Util\Utils;

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
        $this->phpDefault = Utils::renderPhpDefault($default);
    }

    public static function create(\stdClass $field, ?string $namespace = null): AvroField {
        $type = AvroTypeFactory::create($field->type, $namespace);
        return new AvroField($field->name, $field->doc ?? null, $type, $field->default ?? null);
    }

}