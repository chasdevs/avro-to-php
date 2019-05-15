<?php

namespace TestRecords;

class RecordWithArray {

    /** @var Thing[] */
    private $things;

    public function getThings(): array
    {
        return $this->things;
    }

    /**
     * @param Thing[] $things
     * @return RecordWithArray
     */
    public function setThings(array $things): RecordWithArray
    {
        $this->things = $things;
        return $this;
    }



    public const schema = <<<SCHEMA
{
    "type": "record",
    "name": "RecordWithArray",
    "namespace": "testrecords",
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