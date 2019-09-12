<?php

namespace Tests\Records;

use Tests\Expected\Flavor;
use Tests\Expected\RecordWithArray;
use Tests\Expected\RecordWithEnum;
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

}
