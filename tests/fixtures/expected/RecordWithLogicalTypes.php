<?php

namespace Tests\Expected\Records;

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

    public function jsonSerialize(): array
    {
        return [
            "timestamp" => $this->encode($this->timestamp)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithLogicalTypes",
    "namespace": "records",
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