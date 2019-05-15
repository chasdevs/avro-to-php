<?php

namespace AvroToPhp\Compiler\Avro;

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
 */
class AvroType extends Enum implements AvroTypeInterface
{
    private const RECORD = 'record';
    private const BOOLEAN = 'boolean';
    private const INT = 'int';
    private const LONG = 'long';
    private const FLOAT = 'float';
    private const DOUBLE = 'double';
    private const BYTES = 'bytes';
    private const STRING = 'string';
    private const ENUM = 'enum';
    private const ARRAY = 'array';
    private const MAP = 'map';
    private const FIXED = 'fixed';

    public function getPhpType(): string {
        $map = [
            self::BOOLEAN => 'bool',
            self::INT => 'int',
            self::LONG => 'int',
            self::FLOAT => 'float',
            self::DOUBLE => 'float',
            self::BYTES => 'string',
            self::STRING => 'string',
            self::RECORD => '<record>',
            self::ENUM => '',
            self::ARRAY => '<array>',
            self::MAP => '',
            self::FIXED => '',
        ];
        return $map[$this->getValue()];
    }

    public function is(string $value) {
        return $this->equals(new AvroType($value));
    }
}