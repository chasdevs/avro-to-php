<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Thing;

class RecordWithRecord extends BaseRecord
{

    /** @var Thing */
    private $thing1;

    /** @var Thing */
    private $thing2;

    /** @return Thing */
    public function getThing1(): Thing
    {
        return $this->thing1;
    }

    /** @param Thing $thing1 */
    public function setThing1(Thing $thing1): RecordWithRecord
    {
        $this->thing1 = $thing1;
        return $this;
    }

    /** @return Thing */
    public function getThing2(): Thing
    {
        return $this->thing2;
    }

    /** @param Thing $thing2 */
    public function setThing2(Thing $thing2): RecordWithRecord
    {
        $this->thing2 = $thing2;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "thing1" => $this->encode($this->thing1),
            "thing2" => $this->encode($this->thing2)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithRecord",
    "namespace": "records",
    "fields": [
        {
            "name": "thing1",
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
            "name": "thing2",
            "type": "Thing"
        }
    ]
}
SCHEMA;
    }

    protected $propClassMap = [
        "thing1" => "Tests\Expected\Records\Thing",
        "thing2" => "Tests\Expected\Records\Thing"
    ];

}