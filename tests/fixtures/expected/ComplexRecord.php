<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Thing;
use Tests\Expected\Records\Nested\Flavor;

class ComplexRecord extends BaseRecord
{

    /** @var Thing */
    private $thing;

    /** @var Flavor */
    private $flavor;

    /** @return Thing */
    public function getThing(): Thing
    {
        return $this->thing;
    }

    /** @param Thing $thing */
    public function setThing(Thing $thing): ComplexRecord
    {
        $this->thing = $thing;
        return $this;
    }

    /** @return Flavor */
    public function getFlavor(): Flavor
    {
        return $this->flavor;
    }

    /** @param Flavor $flavor */
    public function setFlavor(Flavor $flavor): ComplexRecord
    {
        $this->flavor = $flavor;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            "thing" => $this->encode($this->thing),
            "flavor" => $this->encode($this->flavor)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "ComplexRecord",
    "namespace": "records",
    "fields": [
        {
            "name": "thing",
            "type": {
                "type": "record",
                "name": "Thing",
                "fields": [
                    {
                        "name": "id",
                        "type": "int"
                    }
                ]
            }
        },
        {
            "name": "flavor",
            "type": {
                "type": "enum",
                "name": "Flavor",
                "namespace": "records.nested",
                "symbols": [
                    "VANILLA",
                    "CHOCOLATE",
                    "STRAWBERRY"
                ]
            }
        }
    ]
}
SCHEMA;
    }

}