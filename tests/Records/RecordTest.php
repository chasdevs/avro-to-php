<?php

namespace Tests\Records;

use Tests\Expected\Records\Nested\Flavor;
use Tests\Expected\Records\RecordWithArray;
use Tests\Expected\Records\RecordWithEnum;
use Tests\Expected\Records\RecordWithRecord;
use Tests\Expected\Records\Thing;
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

        $this->assertEquals($expected, $decodedRecord);
        $this->assertEquals(Flavor::VANILLA(), $decodedRecord->getFavoriteFlavor());

    }

    public function testDecodeRecord()
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

    public function testRecordDefaults()
    {
        $record = new RecordWithRecord();
        $expectedThing2 = new Thing(["id" => 0]);

        $this->assertEquals($expectedThing2, $record->getThing2());

        $record = new RecordWithRecord(["thing2" => ["id" => 1]]);
        $expectedThing2 = new Thing(["id" => 1]);

        $this->assertEquals($expectedThing2, $record->getThing2());
    }

}
