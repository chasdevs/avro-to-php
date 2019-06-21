<?php

namespace Tests\Expected;

use Tests\Expected\BaseRecord;

class RecordWithLogicalTypes extends BaseRecord
{

    /** @var int */
    private $timestamp;

    /** @return int */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /** @param int $timestamp */
    public function setTimestamp(int $timestamp): RecordWithLogicalTypes
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "timestamp" => $this->encode($this->timestamp),
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithLogicalTypes",
    "fields": [
        {
            "name": "timestamp",
            "type": {
                "type": "long",
                "logicalType": "timestamp-millis"
            }
        }
    ]
}
SCHEMA;
    }

}