<?php

namespace AvroToPhp\Compiler\Avro;

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

    public function decode($data, ?string $namespace = '')
    {
        return collect($data)->map(function($item) {
            return $this->items->decode($item);
        });
    }

}