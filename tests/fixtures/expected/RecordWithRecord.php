<?php

namespace Tests\Expected;

use Tests\Expected\BaseRecord;
use Tests\Expected\Thing;

class RecordWithRecord extends BaseRecord
{

    /** @var Thing */
    private $thing;

    /** @return Thing */
    public function getThing(): Thing
    {
        return $this->thing;
    }

    /** @param Thing $thing */
    public function setThing(Thing $thing): RecordWithRecord
    {
        $this->thing = $thing;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "thing" => $this->encode($this->thing),
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithArray",
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
        }
    ]
}
SCHEMA;
    }

    protected $propClassMap = [
        "thing" => "Tests\Expected\Thing"
    ];

}