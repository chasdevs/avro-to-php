<?php

use AvroToPhp\Util\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase {

    public function testRsearch() {
        $results = Utils::rsearch('../fixtures', '/.*.avsc$/');
        $this->assertEquals(['../fixtures/avsc/ExampleEvent.avsc'], $results);
    }

}
