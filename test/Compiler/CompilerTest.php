<?php

use AvroToPhp\Compiler\Compiler;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase {

    private $avscFile = '../fixtures/avsc/ExampleEvent.avsc';

    public function testCompile() {
        $compiler = new Compiler();
        $output = $compiler->avscFileToPhp($this->avscFile);
        $expected = file_get_contents('../fixtures/expected/ExampleEvent.php');
        $this->assertIsString($output);

        $this->assertEquals($expected, $output);
    }

}
