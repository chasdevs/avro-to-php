<?php


namespace App\Compiler\Avro;


interface AvroTypeInterface
{
    public function getPhpType(): string;
    public function getPhpDocType(): string;
}