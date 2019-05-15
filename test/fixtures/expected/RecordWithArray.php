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
            "name": "salary",
            "type": "long"
        }
    ]
}
SCHEMA;

}