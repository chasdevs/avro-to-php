<?php

use AvroToPhp\Compiler\Compiler;
use AvroToPhp\Util\Utils;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{

    private const avscDir = '../fixtures/avsc/sample-events';
    private const avscFile = '../fixtures/avsc/ExampleEvent.avsc';
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
        $compiler = new Compiler();
        $output = $compiler->compileFile(self::avscFile);
        $expected = file_get_contents('../fixtures/expected/ExampleEvent.php');
        $this->assertIsString($output);

        $this->assertEquals($expected, $output);
    }

}
