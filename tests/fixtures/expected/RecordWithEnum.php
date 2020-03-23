<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Nested\Flavor;

class RecordWithEnum extends BaseRecord
{

    /** @var Flavor */
    private $favoriteFlavor;

    /** @return Flavor */
    public function getFavoriteFlavor(): Flavor
    {
        return $this->favoriteFlavor;
    }

    /** @param Flavor $favoriteFlavor */
    public function setFavoriteFlavor(Flavor $favoriteFlavor): RecordWithEnum
    {
        $this->favoriteFlavor = $favoriteFlavor;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "favoriteFlavor" => $this->encode($this->favoriteFlavor)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithEnum",
    "namespace": "records",
    "fields": [
        {
            "name": "favoriteFlavor",
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