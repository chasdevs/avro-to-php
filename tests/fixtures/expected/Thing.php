<?php

namespace Testrecords;

class Thing implements \JsonSerializable
{

    /** @var int */
    private $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Thing
    {
        $this->id = $id;
        return $this;
    }

    public function data(): array {
        return $this->encode($this);
    }

    private function encode($mixed) {
        return json_decode(json_encode($mixed), true);
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->encode($this->id)
        ];
    }

    public const schema = <<<SCHEMA
{
  "type": "record",
  "name": "Thing",
  "namespace": "testrecords",
  "fields": [
    {
      "name": "id",
      "type": "int"
    }
  ]
}
SCHEMA;

}