<?php

namespace Sample\Common;

class SharedMeta
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