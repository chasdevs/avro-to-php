<?php

namespace App\Compiler\Avro;

use MyCLabs\Enum\Enum;
use Tests\Expected\BaseRecord;

class AvroEnum implements AvroTypeInterface, AvroNameInterface
{

    use HasName;

    /** @var string[] */
    public $symbols;

    /**
     * @param string $name
     * @param string[] $symbols
     */
    public function __construct(string $name, ?string $namespace, array $symbols)
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->symbols = $symbols;
        $this->configurePhpNamespace();
    }

    public static function create(\stdClass $typeRaw, ?string $namespace = null): AvroEnum
    {
        return new self($typeRaw->name, $typeRaw->namespace ?? $namespace ?? null, $typeRaw->symbols);
    }

    public function getPhpType(): string
    {
        return $this->name;
    }

    public function getPhpDocType(): string
    {
        return $this->getPhpType();
    }

    public function getType(): AvroType
    {
        return AvroType::ENUM();
    }

    public function getImports(): array
    {
        return [$this->getQualifiedPhpType()];
    }

    public function decode($data, ?string $namespace = '')
    {
        $class = $this->getQualifiedPhpType();
        return new $class($data);
    }
}