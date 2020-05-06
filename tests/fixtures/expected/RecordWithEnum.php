<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Nested\Flavor;

class RecordWithEnum extends BaseRecord
{

    /** @var Flavor */
    private $favoriteFlavor;

    /** @var Flavor */
    private $favoriteFlavor2;

    /** @var null|Flavor */
    private $nullableFlavor;

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

    /** @return Flavor */
    public function getFavoriteFlavor2(): Flavor
    {
        return $this->favoriteFlavor2;
    }

    /** @param Flavor $favoriteFlavor2 */
    public function setFavoriteFlavor2(Flavor $favoriteFlavor2): RecordWithEnum
    {
        $this->favoriteFlavor2 = $favoriteFlavor2;
        return $this;
    }

    /** @return null|Flavor */
    public function getNullableFlavor()
    {
        return $this->nullableFlavor;
    }

    /** @param null|Flavor $nullableFlavor */
    public function setNullableFlavor($nullableFlavor): RecordWithEnum
    {
        $this->nullableFlavor = $nullableFlavor;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "favoriteFlavor" => $this->encode($this->favoriteFlavor),
            "favoriteFlavor2" => $this->encode($this->favoriteFlavor2),
            "nullableFlavor" => $this->encode($this->nullableFlavor)
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
        },
        {
            "name": "favoriteFlavor2",
            "type": "records.nested.Flavor"
        },
        {
            "name": "nullableFlavor",
            "type": [
                "null",
                "records.nested.Flavor"
            ]
        }
    ]
}
SCHEMA;
    }

}