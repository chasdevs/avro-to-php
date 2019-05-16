<?php

namespace Tests\Expected;

use Tests\Expected\BaseRecord;

class RecordWithUnion extends BaseRecord
{

    /** @var string|null */
    private $optionalString;

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

    public function jsonSerialize()
    {
        return [
            "optionalString" => $this->encode($this->optionalString),
        ];
    }

    public const schema = <<<SCHEMA
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
        }
    ]
}
SCHEMA;

}