<?php

namespace App\Compiler\Avro;

use MyCLabs\Enum\Enum;

/**
 * @method static AvroType RECORD()
 * @method static AvroType BOOLEAN()
 * @method static AvroType INT()
 * @method static AvroType LONG()
 * @method static AvroType FLOAT()
 * @method static AvroType DOUBLE()
 * @method static AvroType BYTES()
 * @method static AvroType STRING()
 * @method static AvroType ENUM()
 * @method static AvroType ARRAY()
 * @method static AvroType MAP()
 * @method static AvroType FIXED()
 * @method static AvroType NULL()
 */
class AvroType extends Enum implements AvroTypeInterface
{

    // Primitive Types
    private const BOOLEAN = 'boolean';
    private const INT = 'int';
    private const LONG = 'long';
    private const FLOAT = 'float';
    private const DOUBLE = 'double';
    private const BYTES = 'bytes';
    private const STRING = 'string';
    private const NULL = 'null';

    // Complex Types
    private const RECORD = 'record';
    private const ENUM = 'enum';
    private const ARRAY = 'array';
    private const MAP = 'map';
    private const FIXED = 'fixed';

    public function is(string $value) {
        return $this->equals(new AvroType($value));
    }

    public function getPhpType(): string {
        $map = [
            self::BOOLEAN => 'bool',
            self::INT => 'int',
            self::LONG => 'int',
            self::FLOAT => 'float',
            self::DOUBLE => 'float',
            self::BYTES => 'string',
            self::STRING => 'string',
            self::NULL => 'null'
        ];
        return $map[$this->getValue()];
    }

    public function getPhpDocType(): string
    {
        return $this->getPhpType();
    }
}