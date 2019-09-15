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

    public static function create(\stdClass $array): AvroArray {
        $type = AvroTypeFactory::create($array->items);
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

    public function getCompilePath(): string
    {
        throw new NotImplementedException('Cannot compile type directly.');
    }
}