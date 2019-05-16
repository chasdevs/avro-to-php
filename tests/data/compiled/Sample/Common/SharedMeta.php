<?php

namespace Sample\Common;

use App\BaseRecord;

class SharedMeta extends BaseRecord
{

    /** @var string */
    private $uuid;

    /** @return string */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /** @param string $uuid */
    public function setUuid(string $uuid): SharedMeta
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "uuid" => $this->encode($this->uuid),
        ];
    }

    public const schema = <<<SCHEMA
{
    "type": "record",
    "name": "SharedMeta",
    "namespace": "sample.common",
    "fields": [
        {
            "name": "uuid",
            "type": "string"
        }
    ]
}
SCHEMA;

}