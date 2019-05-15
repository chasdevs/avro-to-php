<?php

namespace AvroToPhp\Compiler\Avro;

class AvroUnion implements AvroTypeInterface
{

    /** @var AvroTypeInterface[] */
    public $types;

    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public static function create(array $types): AvroUnion {

        $types = array_map(function ($type) {
            return AvroTypeFactory::create($type);
        }, $types);

        return new self($types);
    }

    public function getPhpType(): string
    {
        return '';
    }

    public function getPhpDocType(): string
    {
        $phpDocTypes = array_map(function (AvroTypeInterface $type) {
            return $type->getPhpDocType();
        }, $this->types);

        return join('|', $phpDocTypes);
    }
}