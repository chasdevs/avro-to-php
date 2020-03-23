<?php

namespace AvroToPhp\Compiler\Avro;

interface AvroNameInterface
{
    public function getCompilePath(): string;
    public function getQualifiedPhpType(): string;
}