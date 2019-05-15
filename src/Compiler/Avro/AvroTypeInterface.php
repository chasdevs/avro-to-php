<?php


namespace AvroToPhp\Compiler\Avro;


interface AvroTypeInterface
{
    public function getPhpType(): string;
}