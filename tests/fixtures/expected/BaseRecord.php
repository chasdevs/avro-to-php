<?php

namespace Tests\Expected;

use App\Compiler\Avro\AvroField;
use App\Compiler\Avro\AvroRecord;
use App\Compiler\Avro\AvroType;
use App\Compiler\Avro\AvroType as AvroTypeAlias;
use App\Compiler\Avro\AvroTypeFactory;
use JsonSerializable;
use MyCLabs\Enum\Enum;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class BaseRecord implements JsonSerializable
{

    /**
     * In order to decode an arbitrary array of data into typed sub-records, a record must store a map of property name to qualified type.
     */
    protected $propClassMap = [];

    /**
     * For more complex defaults, such as records within records, we can set
     */
    protected $defaults = [];

    public function __construct(array $data = [])
    {
        if ($this->defaults) {
            $this->decode($this->defaults);
        }

        if ($data) {
            $this->decode($data);
        }
    }

    public abstract function schema(): string;

    public function name(): string
    {
        $reflect = new ReflectionClass($this);
        return $reflect->getShortName();
    }

    public function setData(array $data)
    {
        $this->decode($data);
    }

    public function data(): array
    {
        return $this->encode($this);
    }

    protected function encode($mixed)
    {
        return json_decode(json_encode($mixed), true);
    }

    /**
     * TODO: Create a more elegant solution here; read in the expected schema and decode each field using AvroRecord, etc.
     * @param array $array - Array holding arbitrary data to be decoded into this object.
     * @throws ReflectionException
     * @throws \App\Compiler\Errors\NotImplementedException
     */
    public function decode(array $array)
    {

        $record = AvroRecord::create(json_decode($this->schema()), 'one.two');

        /** @var AvroField[] $fieldMap */
        $fieldMap = collect($record->fields)->mapWithKeys(function (AvroField $field) {
            return [$field->name => $field];
        });

        $refl = new ReflectionClass($this);

        foreach ($array as $propertyToSet => $value) {

            try {
                $prop = $refl->getProperty($propertyToSet);
            } catch (ReflectionException $e) {
                continue;
            }

            if (!$prop instanceof ReflectionProperty) {
                continue;
            }

            $propName = $prop->getName();
            $field = $fieldMap[$propName];

            // New method: Identify the type based on $fieldMap and decode accordingly
            if (AvroType::MAP()->is($field->type->getType())) {
                //decode map
                $value = $field->type->decode($value, __NAMESPACE__);
            } else if (key_exists($propName, $this->propClassMap)) {
                // Old method: Decode sub-records and enums by looking up the property name in the propMap on the php record.
                $value = $this->getValueForComplexPropType($propName, $value);
            }

            $prop->setAccessible(true);
            $prop->setValue($this, $value);
        }
    }

    /**
     * @param string $propName - The property name we are trying to decode.
     * @param string|array $value - The encoded value in array or string form. Sub-records will be arrays and enums strings.
     * @return BaseRecord|Enum
     * @throws ReflectionException
     */
    private function getValueForComplexPropType(string $propName, $value)
    {
        $class = $this->propClassMap[$propName];
        $refl = new ReflectionClass($class);
        if ($refl->isSubclassOf(BaseRecord::class)) {
            /** @var BaseRecord $subRecord */
            $subRecord = new $class;
            $subRecord->decode($value);
            return $subRecord;
        } else if ($refl->isSubclassOf(Enum::class)) {
            return new $class($value);
        }
    }

}