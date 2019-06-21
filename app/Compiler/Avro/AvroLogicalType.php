<?php

namespace App\Compiler\Avro;

class AvroLogicalType implements AvroTypeInterface
{

    /** @var AvroTypeInterface */
    public $type;

    /** @var string */
    public $logicalType;

    public function __construct(AvroTypeInterface $type, string $logicalType)
    {
        $this->type = $type;
        $this->logicalType = $logicalType;
    }

    public static function create(\stdClass $type): AvroLogicalType
    {
        return new self(new AvroType($type->type), $type->logicalType);
    }

    public function getPhpType(): string
    {
        return $this->type->getPhpType();
    }

    public function getPhpDocType(): string
    {
        return $this->type->getPhpDocType();
    }
}