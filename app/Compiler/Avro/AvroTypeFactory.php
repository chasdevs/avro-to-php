<?php

namespace App\Compiler\Avro;

use App\Compiler\Errors\NotImplementedException;

class AvroTypeFactory {

    public static function create($type): AvroTypeInterface {
        if (is_object($type) && AvroType::RECORD()->is($type->type)) {
            return AvroRecord::create($type);
        } else if (is_object($type) && AvroType::ARRAY()->is($type->type)) {
            return AvroArray::create($type);
        } else if (is_array($type)) {
            return AvroUnion::create($type);
        } else if (is_string($type)) {
            // primitive type
            return new AvroType($type);
        } else {
            throw new NotImplementedException('Unknown Avro Type');
        }
    }
}