<?php

namespace Tests\Records;

use AvroIOBinaryEncoder;
use AvroSchema;
use AvroIODatumWriter;

use AvroStringIO;
use Exception;
use Tests\Expected\BaseRecord;
use Tests\Expected\Records\RecordWithNestedMap;
use Tests\Expected\Records\Thing;
use Tests\TestCase;

class SerializeTest extends TestCase
{

    public function testRecordWithNestedMapSerializes()
    {
        $record1 = new RecordWithNestedMap(["thingMapMap" => ["key1" => ["id" => 1]]]);
        $this->assertSerializes($record1);

        $record2 = new RecordWithNestedMap();
        $record2->setThingMapMap([
            "key1" => ["key2" => new Thing(["id" => 2])]
        ]);
        $this->assertSerializes($record2);
    }

    private function assertSerializes(BaseRecord $event) : void
    {
        $serializes = false;
        try {
            $schema = AvroSchema::parse($event->schema());
            $writer = new AvroIODatumWriter($schema);
            $written = new AvroStringIO();
            $encoder = new AvroIOBinaryEncoder($written);
            $writer->write($event->data(), $encoder);
            $serializes = true;
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue($serializes);
    }

}
