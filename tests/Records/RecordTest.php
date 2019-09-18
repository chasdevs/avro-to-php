<?php

namespace Tests\Records;

use Tests\Expected\Flavor;
use Tests\Expected\RecordWithArray;
use Tests\Expected\RecordWithEnum;
use Tests\Expected\RecordWithRecord;
use Tests\Expected\Thing;
use Tests\TestCase;

class RecordTest extends TestCase
{

    public function testData()
    {

        $things = [
            (new Thing())->setId(1),
            (new Thing())->setId(2),
        ];

        $record = (new RecordWithArray())
            ->setNumbers([1, 3])
            ->setThings($things);

        $this->assertEquals(['numbers' => [1, 3], 'things' => [
            ['id' => 1],
            ['id' => 2],
        ]], $record->data());
    }

    public function testEnum()
    {
        $record = (new RecordWithEnum())
            ->setFavoriteFlavor(Flavor::STRAWBERRY());

        $this->assertEquals(['favoriteFlavor' => 'STRAWBERRY'], $record->data());
    }

    public function testDecodeEnum()
    {

        $expected = new RecordWithEnum();
        $expected->setFavoriteFlavor(Flavor::VANILLA());

        $decodedRecord = new RecordWithEnum();
        $decodedRecord->decode(['favoriteFlavor' => 'VANILLA']);

        var_dump($decodedRecord);
        $this->assertEquals($expected, $decodedRecord);
        $this->assertEquals(Flavor::VANILLA(), $decodedRecord->getFavoriteFlavor());

    }

    public function testDecodeRecordWithRecord()
    {

        $thing = new Thing();
        $thing->setId(1);

        $expected = new RecordWithRecord();
        $expected->setThing1($thing);

        $decodedRecord = new RecordWithRecord();
        $decodedRecord->decode(['thing1' => ['id' => 1]]);

        $this->assertEquals(1, $decodedRecord->getThing1()->getId());
        $this->assertEquals($expected, $decodedRecord);

    }

    public function testDecodeRecordWithArray()
    {

        $thing = new Thing();
        $thing->setId(1);

        $expected = new RecordWithArray();
        $expected->setThings([$thing]);

        $decodedRecord = new RecordWithArray();
        $decodedRecord->decode(['things' => [['id' => 1]]]);

        $this->assertEquals(1, $decodedRecord->getThings()[0]->getId());
        $this->assertEquals($expected, $decodedRecord);

    }

}
