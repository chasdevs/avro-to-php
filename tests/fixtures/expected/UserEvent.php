<?php

namespace Tests\Expected\Sample\User;

use Tests\Expected\BaseRecord;
use Tests\Expected\Sample\Common\SharedMeta;

class UserEvent extends BaseRecord
{

    /** @var SharedMeta */
    private $meta;

    /** @var int */
    private $userId;

    /** @return SharedMeta */
    public function getMeta(): SharedMeta
    {
        return $this->meta;
    }

    /** @param SharedMeta $meta */
    public function setMeta(SharedMeta $meta): UserEvent
    {
        $this->meta = $meta;
        return $this;
    }

    /** @return int */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /** @param int $userId */
    public function setUserId(int $userId): UserEvent
    {
        $this->userId = $userId;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "meta" => $this->encode($this->meta),
            "userId" => $this->encode($this->userId)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "UserEvent",
    "namespace": "sample.user",
    "fields": [
        {
            "name": "meta",
            "type": {
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
        },
        {
            "name": "userId",
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