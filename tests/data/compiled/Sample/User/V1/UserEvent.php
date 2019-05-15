<?php

namespace Sample\User\V1;

use Sample\Common\SharedMeta;

class UserEvent
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

    public const schema = <<<SCHEMA
{
    "type": "record",
    "name": "UserEvent",
    "namespace": "sample.user.v1",
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