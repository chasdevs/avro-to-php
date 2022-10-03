<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Thing;

class RecordWithUnion extends BaseRecord
{

    /** @var string|null */
    private $optionalString;

    /** @var int|Thing */
    private $intOrThing;

    /** @var null|Thing */
    private $nullOrThing;

    /** @return string|null */
    public function getOptionalString()
    {
        return $this->optionalString;
    }

    /** @param string|null $optionalString */
    public function setOptionalString($optionalString): RecordWithUnion
    {
        $this->optionalString = $optionalString;
        return $this;
    }

    /** @return int|Thing */
    public function getIntOrThing()
    {
        return $this->intOrThing;
    }

    /** @param int|Thing $intOrThing */
    public function setIntOrThing($intOrThing): RecordWithUnion
    {
        $this->intOrThing = $intOrThing;
        return $this;
    }

    /** @return null|Thing */
    public function getNullOrThing()
    {
        return $this->nullOrThing;
    }

    /** @param null|Thing $nullOrThing */
    public function setNullOrThing($nullOrThing): RecordWithUnion
    {
        $this->nullOrThing = $nullOrThing;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            "optionalString" => $this->encode($this->optionalString),
            "intOrThing" => $this->encode($this->intOrThing),
            "nullOrThing" => $this->encode($this->nullOrThing)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithUnion",
    "namespace": "records",
    "fields": [
        {
            "name": "optionalString",
            "type": [
                "string",
                "null"
            ]
        },
        {
            "name": "intOrThing",
            "type": [
                "int",
                {
                    "type": "record",
                    "name": "Thing",
                    "fields": [
                        {
                            "name": "id",
                            "type": "int"
                        }
                    ]
                }
            ]
        },
        {
            "name": "nullOrThing",
            "type": [
                "null",
                "Thing"
            ]
        }
    ]
}
SCHEMA;
    }

}