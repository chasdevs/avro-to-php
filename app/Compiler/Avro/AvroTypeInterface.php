<?php


namespace App\Compiler\Avro;


interface AvroTypeInterface
{
    public function getType(): AvroType;
    public function getPhpType(): string;
    public function getPhpDocType(): string;
    public function getImports(): array;
}