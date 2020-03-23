<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Thing;

class RecordWithNestedMap extends BaseRecord
{

    /** @var Thing[][] */
    private $thingMapMap;

    /** @return Thing[][] */
    public function getThingMapMap(): array
    {
        return $this->thingMapMap;
    }

    /** @param Thing[][] $thingMapMap */
    public function setThingMapMap(array $thingMapMap): RecordWithNestedMap
    {
        $this->thingMapMap = $thingMapMap;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "thingMapMap" => $this->encode($this->thingMapMap)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithNestedMap",
    "namespace": "records",
    "fields": [
        {
            "name": "thingMapMap",
            "type": {
                "type": "map",
                "values": {
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
        }
    ]
}
SCHEMA;
    }

}