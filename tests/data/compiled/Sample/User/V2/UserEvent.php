<?php

namespace Sample\User\V2;

use App\BaseRecord;

use Sample\Common\SharedMeta;

class UserEvent extends BaseRecord
{

    /** @var SharedMeta */
    private $meta;

    /** @var int */
    private $userId;

    /** @var string */
    private $name;

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

    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }

    /** @param string $name */
    public function setName(string $name): UserEvent
    {
        $this->name = $name;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "meta" => $this->encode($this->meta),
            "userId" => $this->encode($this->userId),
            "name" => $this->encode($this->name),
        ];
    }

    public const schema = <<<SCHEMA
{
    "type": "record",
    "name": "UserEvent",
    "namespace": "sample.user.v2",
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
        },
        {
            "name": "name",
            "type": "string",
            "default": ""
        }
    ]
}
SCHEMA;

}