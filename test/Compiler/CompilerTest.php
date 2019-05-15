<?php

use AvroToPhp\Compiler\Compiler;
use AvroToPhp\Util\Utils;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{

    private const avscDir = '../fixtures/avsc/sample-events';
    private const outDir = '../data/compiled';

    public static function setUpBeforeClass()
    {
        Utils::rmDir(self::outDir);
    }


    public function testCompile()
    {
        $compiler = new Compiler();
        $compiler->compile(self::avscDir, self::outDir);

        // verify folder structure
        $output = Utils::find(self::outDir, '/.*/');
        $this->assertEquals([
            Utils::joinPaths(self::outDir, 'Sample/User/V1/UserEvent.php'),
            Utils::joinPaths(self::outDir, 'Sample/User/V2/UserEvent.php'),
            Utils::joinPaths(self::outDir, 'Sample/Common/SharedMeta.php'),
        ], $output);

    }

    public function testCompileFile()
    {
        $expected = file_get_contents('../fixtures/expected/ExampleEvent.php');

        $compiler = new Compiler();
        $actual = $compiler->compileFile('../fixtures/avsc/ExampleEvent.avsc');

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileFileWithArray()
    {
        $expected = file_get_contents('../fixtures/expected/RecordWithArray.php');

        $compiler = new Compiler();
        $actual = $compiler->compileFile('../fixtures/avsc/RecordWithArray.avsc');

        echo $actual;

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

}
