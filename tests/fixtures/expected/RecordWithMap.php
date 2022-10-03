<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Thing;

class RecordWithMap extends BaseRecord
{

    /** @var Thing[] */
    private $thingMap;

    /** @return Thing[] */
    public function getThingMap(): array
    {
        return $this->thingMap;
    }

    /** @param Thing[] $thingMap */
    public function setThingMap(array $thingMap): RecordWithMap
    {
        $this->thingMap = $thingMap;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            "thingMap" => $this->encode($this->thingMap)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithMap",
    "namespace": "records",
    "fields": [
        {
            "name": "thingMap",
            "type": {
                "type": "map",
                "values": {
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
        }
    ]
}
SCHEMA;
    }

}