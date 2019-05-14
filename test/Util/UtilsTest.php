<?php

use AvroToPhp\Util\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase {

    public function testJoinPaths()
    {
        $expected = 'one'.DIRECTORY_SEPARATOR.'two'.DIRECTORY_SEPARATOR.'three'.DIRECTORY_SEPARATOR.'four';
        $actual = Utils::joinPaths('one', '/two/three', 'four');
        $this->assertEquals($expected, $actual);
    }
    public function testRsearch() {
        $results = Utils::rsearch('../fixtures', '/.*.avsc$/');
        $this->assertEquals(['../fixtures/avsc/ExampleEvent.avsc'], $results);
    }

}
