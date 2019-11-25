<?php

namespace Tests\Expected;

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
     * @param array $array - Array holding arbitrary data to be decoded into this object.
     */
    public function decode(array $array)
    {
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
            if (key_exists($propName, $this->propClassMap)) {
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