<?php


namespace AvroToPhp\Compiler\Avro;


interface AvroTypeInterface
{
    public function getType(): AvroType;
    public function getPhpType(): string;
    public function getPhpDocType(): string;
    public function getImports(): array;
    public function decode($data, ?string $namespace = '');
}