<?php

namespace App\Compiler\Avro;

use App\Compiler\Errors\NotImplementedException;

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

    public function getType(): AvroType
    {
        return AvroType::UNION();
    }

    public function getImports(): array
    {
        return array_reduce($this->types, function(array $carry, AvroTypeInterface $type) {
            $carry += $type->getImports();
            return $carry;
        }, []);
    }

}