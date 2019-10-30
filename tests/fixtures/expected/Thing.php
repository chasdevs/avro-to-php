<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;

class Thing extends BaseRecord
{

    /** @var int */
    private $id;

    /** @return int */
    public function getId(): string
    {
        return $this->id;
    }

    /** @param int $id */
    public function setId(int $id): Thing
    {
        $this->id = $id;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->encode($this->id)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
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
SCHEMA;
    }

}