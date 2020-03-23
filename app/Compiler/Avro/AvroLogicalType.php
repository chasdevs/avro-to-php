<?php

namespace App\Compiler\Avro;

use App\Compiler\Errors\NotImplementedException;

class AvroLogicalType implements AvroTypeInterface
{

    /** @var AvroTypeInterface */
    public $type;

    /** @var string */
    public $logicalType;

    public function __construct(AvroType $type, string $logicalType)
    {
        $this->type = $type;
        $this->logicalType = $logicalType;
    }

    public static function create(\stdClass $typeDef): AvroLogicalType
    {
        return new self(new AvroType($typeDef->type), $typeDef->logicalType);
    }

    public function getPhpType(): string
    {
        return $this->type->getPhpType();
    }

    public function getPhpDocType(): string
    {
        return $this->type->getPhpDocType();
    }

    public function getName(): string
    {
        throw new NotImplementedException("Unnamed type: ".$this->type);
    }

    public function getType(): AvroType
    {
        return AvroType::LOGICAL_TYPE();
    }

    public function getImports(): array
    {
        return [];
    }

    public function decode($data, ?string $namespace = '')
    {
        return $data;
    }
}