<?php

namespace Tests\Expected\Records;

use Tests\Expected\BaseRecord;
use Tests\Expected\Records\Thing;

class RecordWithArray extends BaseRecord
{

    /** @var Thing[] */
    private $things;

    /** @var int[] */
    private $numbers;

    /** @return Thing[] */
    public function getThings(): array
    {
        return $this->things;
    }

    /** @param Thing[] $things */
    public function setThings(array $things): RecordWithArray
    {
        $this->things = $things;
        return $this;
    }

    /** @return int[] */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

    /** @param int[] $numbers */
    public function setNumbers(array $numbers): RecordWithArray
    {
        $this->numbers = $numbers;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "things" => $this->encode($this->things),
            "numbers" => $this->encode($this->numbers)
        ];
    }

    public function schema(): string
    {
        return <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithArray",
    "namespace": "records",
    "fields": [
        {
            "name": "things",
            "type": {
                "type": "array",
                "items": {
                    "type": "record",
                    "name": "Thing",
                    "fields": [
                        {
                            "name": "id",
                            "type": "int"
                        }
                    ]
                }
            }
        },
        {
            "name": "numbers",
            "type": {
                "type": "array",
                "items": "int"
            }
        }
    ]
}
SCHEMA;
    }

}