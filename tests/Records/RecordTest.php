<?php

namespace Tests\Records;

use Tests\Expected\RecordWithArray;
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

        $expected = ['numbers' => [1, 3], 'things' => [
            ['id' => 1],
            ['id' => 2],
        ]];
        $data = $record->data();

        $this->assertEquals($expected, $data);
    }

}
