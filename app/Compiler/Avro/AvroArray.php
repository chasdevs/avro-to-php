<?php

namespace App\Compiler\Avro;

use App\Compiler\Errors\NotImplementedException;

class AvroArray implements AvroTypeInterface
{

    /** @var AvroTypeInterface */
    public $items;

    public function __construct(AvroTypeInterface $items)
    {
        $this->items = $items;
    }

    public static function create(\stdClass $array, ?string $namespace): AvroArray {
        $type = AvroTypeFactory::create($array->items, $namespace);
        return new self($type);
    }

    public function getPhpType(): string
    {
        return 'array';
    }

    public function getPhpDocType(): string
    {
        return $this->items->getPhpType().'[]';
    }

    public function getType(): AvroType
    {
        return AvroType::ARRAY();
    }

    public function getImports(): array
    {
        return $this->items->getImports();
    }

}