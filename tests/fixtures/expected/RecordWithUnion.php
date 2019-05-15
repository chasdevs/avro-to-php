<?php

class RecordWithUnion
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