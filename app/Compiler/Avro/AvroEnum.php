<?php

namespace App\Compiler\Avro;

class AvroEnum implements AvroTypeInterface
{
    /** @var string */
    public $name;

    /** @var string[] */
    public $symbols;

    /**
     * @param string $name
     * @param string[] $symbols
     */
    public function __construct(string $name, array $symbols)
    {
        $this->name = $name;
        $this->symbols = $symbols;
    }

    public static function create(\stdClass $array): AvroEnum {
        return new self($array->name, $array->symbols);
    }

    public function getPhpType(): string
    {
        return $this->name;
    }

    public function getPhpDocType(): string
    {
        return $this->getPhpType();
    }
}