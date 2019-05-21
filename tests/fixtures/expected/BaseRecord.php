<?php

namespace Tests\Expected;

use JsonSerializable;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseRecord implements JsonSerializable
{
    public abstract function schema(): string;

    public function name(): string
    {
        $reflect = new ReflectionClass($this);
        return $reflect->getShortName();
    }

    public function data(): array
    {
        return $this->encode($this);
    }

    protected function encode($mixed)
    {
        return json_decode(json_encode($mixed), true);
    }

    public function decode(array $array)
    {
        $refl = new ReflectionClass($this);

        foreach ($array as $propertyToSet => $value) {

            try {
                $prop = $refl->getProperty($propertyToSet);
            } catch (\ReflectionException $e) {
                continue;
            }

            if ($prop instanceof ReflectionProperty) {
                $prop->setAccessible(true);
                $prop->setValue($this, $value);
            }
        }
    }
}