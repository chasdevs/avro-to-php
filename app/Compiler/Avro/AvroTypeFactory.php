<?php

namespace AvroToPhp\Compiler\Avro;

use AvroToPhp\Compiler\Errors\NotImplementedException;

class AvroTypeFactory {

    private static $typeCache = [];
    private static $namespaceCache = [];

    public static function create($avsc, ?string $namespace = null): AvroTypeInterface {
        if (is_object($avsc) && AvroType::RECORD()->is($avsc->type)) {
            $record = AvroRecord::create($avsc, $namespace);
            self::cacheType($record);
            return $record;
        } else if (is_object($avsc) && AvroType::ARRAY()->is($avsc->type)) {
            return AvroArray::create($avsc, $namespace);
        } else if (is_object($avsc) && AvroType::ENUM()->is($avsc->type)) {
            $enum = AvroEnum::create($avsc, $namespace);
            self::cacheType($enum);
            return $enum;
        } else if (is_object($avsc) && AvroType::MAP()->is($avsc->type)) {
            return AvroMap::create($avsc, $namespace);
        } else if (is_object($avsc) && property_exists($avsc, "logicalType")) {
            return AvroLogicalType::create($avsc);
        } else if (is_array($avsc)) {
            return AvroUnion::create($avsc, $namespace);
        } else if (key_exists($avsc, self::$typeCache)) {
            return self::$typeCache[$avsc];
        } else if (key_exists($avsc, self::$namespaceCache)) {
            return self::$namespaceCache[$avsc];
        } else if (is_string($avsc)) {
            // primitive type
            return new AvroType($avsc);
        } else {
            throw new NotImplementedException('Unknown Avro Type');
        }
    }

    public static function createNamedType($avsc): AvroNameInterface {
        if (is_object($avsc) && AvroType::RECORD()->is($avsc->type)) {
            return AvroRecord::create($avsc);
        } else if (is_object($avsc) && AvroType::ENUM()->is($avsc->type)) {
            return AvroEnum::create($avsc);
        } else {
            throw new NotImplementedException('Unknown Avro Type');
        }
    }

    private static function cacheType(AvroNameInterface $type) {
        self::$typeCache[$type->name] = $type;

        $qualifiedName = collect([$type->namespace, $type->name])->filter()->join('.');
        self::$namespaceCache[$qualifiedName] = $type;
    }
}