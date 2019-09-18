<?php

namespace Tests\Expected;

use Tests\Expected\BaseRecord;
use Tests\Expected\Thing;

class RecordWithUnion extends BaseRecord
{

    /** @var string|null */
    private $optionalString;

    /** @var int|Thing */
    private $intOrThing;

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

    public function jsonSerialize()
    {
        return [
            "optionalString" => $this->encode($this->optionalString),
            "intOrThing" => $this->encode($this->intOrThing)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithUnion",
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
        }
    ]
}
SCHEMA;
    }

}