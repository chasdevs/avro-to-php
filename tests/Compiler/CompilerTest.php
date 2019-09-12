<?php

namespace Tests\Compiler;

use App\Compiler\Compiler;
use App\Util\Utils;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{

    private const NAMESPACE = 'Tests\Expected';
    private const FIXTURES = __DIR__ . '/../fixtures';
    private const outDir = __DIR__ . '/../data/compiled';
    private const avscDir = __DIR__ . '/../fixtures/avsc/sample-events';

    private const expectedBaseRecord = self::FIXTURES . '/expected/BaseRecord.php';
    private const expectedExampleRecord = self::FIXTURES . '/expected/ExampleEvent.php';
    private const exampleRecord = self::FIXTURES . '/avsc/ExampleEvent.avsc';
    private const expectedRecordWithArray = self::FIXTURES . '/expected/RecordWithArray.php';
    private const recordWithArray = self::FIXTURES . '/avsc/RecordWithArray.avsc';
    private const expectedRecordWithUnion = self::FIXTURES . '/expected/RecordWithUnion.php';
    private const recordWithUnion = self::FIXTURES . '/avsc/RecordWithUnion.avsc';
    private const expectedRecordWithLogicalTypes = self::FIXTURES . '/expected/RecordWithLogicalTypes.php';
    private const recordWithLogicalTypes = self::FIXTURES . '/avsc/RecordWithLogicalTypes.avsc';
    private const expectedRecordWithEnum = self::FIXTURES . '/expected/RecordWithEnum.php';
    private const recordWithEnum = self::FIXTURES . '/avsc/RecordWithEnum.avsc';

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
            Utils::resolve(self::outDir, 'BaseRecord.php'),
        ], $output);

    }

    public function testCompileFile()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedExampleRecord));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::exampleRecord, self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileBaseRecord()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedBaseRecord));

        $compiler = new Compiler();
        $actual = $compiler->compileBaseRecord(self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileRecordWithArray()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedRecordWithArray));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::recordWithArray, self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileRecordWithUnion()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedRecordWithUnion));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::recordWithUnion, self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileRecordWithLogicalTypes()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedRecordWithLogicalTypes));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::recordWithLogicalTypes, self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCompileRecordWithEnum()
    {
        $expected = file_get_contents(Utils::resolve(self::expectedRecordWithEnum));

        $compiler = new Compiler();
        $actual = $compiler->compileFile(self::recordWithEnum, self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

}
