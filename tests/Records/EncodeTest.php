<?php

namespace Tests\Records;

use Tests\Expected\Records\ExampleEvent;
use Tests\Expected\Records\RecordWithMap;
use Tests\Expected\Records\Thing;
use Tests\TestCase;

/**
 * BaseRecord::encode() round-trips values through json_encode()/json_decode(). Without
 * JSON_INVALID_UTF8_SUBSTITUTE, json_encode() returns false for any string containing invalid
 * UTF-8, json_decode(false) yields null, and the field is silently dropped from data().
 */
class EncodeTest extends TestCase
{
    private const INVALID_UTF8 = "abc\xFF";
    private const REPLACEMENT = "abc\u{FFFD}";

    public function testInvalidUtf8InStringFieldIsSubstituted()
    {
        $record = (new ExampleEvent())->setName(self::INVALID_UTF8)->setSalary(1.5);

        $this->assertSame(self::REPLACEMENT, $record->data()['name']);
    }

    public function testInvalidUtf8InMapKeyIsSubstituted()
    {
        $record = (new RecordWithMap())->setThingMap([self::INVALID_UTF8 => (new Thing())->setId(1)]);

        $this->assertSame([self::REPLACEMENT => ['id' => 1]], $record->data()['thingMap']);
    }

    public function testValidUtf8IsUnchanged()
    {
        $record = (new ExampleEvent())->setName('café')->setSalary(1.5);

        $this->assertSame('café', $record->data()['name']);
    }
}
