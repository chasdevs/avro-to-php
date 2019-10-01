<?php

namespace Tests\Expected\Sample\Common;

use Tests\Expected\BaseRecord;
use Tests\Expected\Sample\Common\SharedMeta;

class CommonEvent extends BaseRecord
{

    /** @var SharedMeta */
    private $meta;

    /** @var int */
    private $xyz;

    /** @return SharedMeta */
    public function getMeta(): SharedMeta
    {
        return $this->meta;
    }

    /** @param SharedMeta $meta */
    public function setMeta(SharedMeta $meta): CommonEvent
    {
        $this->meta = $meta;
        return $this;
    }

    /** @return int */
    public function getXyz(): int
    {
        return $this->xyz;
    }

    /** @param int $xyz */
    public function setXyz(int $xyz): CommonEvent
    {
        $this->xyz = $xyz;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "meta" => $this->encode($this->meta),
            "xyz" => $this->encode($this->xyz)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "CommonEvent",
    "namespace": "sample.common",
    "fields": [
        {
            "name": "meta",
            "type": {
                "type": "record",
                "name": "SharedMeta",
                "fields": [
                    {
                        "name": "uuid",
                        "type": "string"
                    }
                ]
            }
        },
        {
            "name": "xyz",
            "type": "int"
        }
    ]
}
SCHEMA;
    }

    protected $propClassMap = [
        "meta" => "Tests\Expected\Sample\Common\SharedMeta"
    ];

}