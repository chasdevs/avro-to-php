<?php

use AvroToPhp\Compiler\Compiler;
use AvroToPhp\Util\Utils;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{

    private const FIXTURES = __DIR__.'/../fixtures';
    private const outDir = __DIR__.'/../data/compiled';
    private const avscDir = __DIR__.'/../fixtures/avsc/sample-events';

    private const expectedExampleRecord = self::FIXTURES.'/expected/ExampleEvent.php';
    private const exampleRecord = self::FIXTURES.'/avsc/ExampleEvent.avsc';
    private const expectedRecordWithArray = self::FIXTURES.'/expected/RecordWithArray.php';
    private const recordWithArray = self::FIXTURES.'/avsc/RecordWithArray.avsc';
    private const expectedRecordWithUnion = self::FIXTURES.'/expected/RecordWithUnion.php';
    private const recordWithUnion = self::FIXTURES.'/avsc/RecordWithUnion.avsc';

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
            Utils::resolve(self::outDir, 'Sample/User/V1/UserEvent.php'),
            Utils::resolve(self::outDir, 'Sample/User/V2/UserEvent.php'),
            Utils::resolve(self::outDir, 'Sample/Common/SharedMeta.php'),
        ], $output);

    }

    public function testCompileFile()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedExampleRecord));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::exampleRecord);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileRecordWithArray()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedRecordWithArray));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::recordWithArray);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileRecordWithUnion()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedRecordWithUnion));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::recordWithUnion);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

}
