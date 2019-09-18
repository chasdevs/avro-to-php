<?php

namespace Tests\Expected;

use Tests\Expected\BaseRecord;
use Tests\Expected\Flavor;

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
            "favoriteFlavor" => $this->encode($this->favoriteFlavor),
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithEnum",
    "fields": [
        {
            "name": "favoriteFlavor",
            "type": {
                "type": "enum",
                "name": "Flavor",
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

    protected $propClassMap = [
        'favoriteFlavor' => 'Tests\Expected\Flavor'
    ];

}