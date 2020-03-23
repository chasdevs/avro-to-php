<?php

namespace AvroToPhp\Compiler\Avro;

class AvroMap implements AvroTypeInterface
{

    /** @var AvroTypeInterface */
    public $values;

    public function __construct(AvroTypeInterface $values)
    {
        $this->values = $values;
    }

    public static function create(\stdClass $map, ?string $namespace): AvroMap {
        $type = AvroTypeFactory::create($map->values, $namespace);
        return new self($type);
    }

    public function getPhpType(): string
    {
        return 'array';
    }

    public function getPhpDocType(): string
    {
        return $this->values->getPhpDocType().'[]';
    }

    public function getType(): AvroType
    {
        return AvroType::MAP();
    }

    public function getImports(): array
    {
        return $this->values->getImports();
    }

    public function decode($data, ?string $namespace = '')
    {
        return collect($data)->mapWithKeys(function($value, $key) use ($namespace) {
            return [$key => $this->values->decode($value, $namespace)];
        })->all();
    }

}