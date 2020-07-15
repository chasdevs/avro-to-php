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

    public static function create(array $types, ?string $namespace): AvroUnion
    {

        $types = array_map(function ($type) use ($namespace) {
            return AvroTypeFactory::create($type, $namespace);
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
        return array_reduce($this->types, function (array $carry, AvroTypeInterface $type) {
            $carry += $type->getImports();
            return $carry;
        }, []);
    }

    public function decode($data, ?string $namespace = '')
    {
        //TODO: Handle multiple enum types

        // return the first non-null type
        foreach($this->types as $type) {
           if (!$type->getType()->is(AvroType::NULL())) {
               return $type->decode($data, $namespace);
           }
        }

        return $data;
    }

}