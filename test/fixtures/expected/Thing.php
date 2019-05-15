<?php

namespace TestRecords;

class Thing {

    /** @var int */
    private $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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