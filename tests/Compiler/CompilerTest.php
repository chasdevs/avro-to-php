<?php

namespace Tests\Compiler;

use App\Compiler\Compiler;
use App\Util\Utils;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{

    private const NAMESPACE = 'Tests\Expected';
    private const FIXTURES = __DIR__ . '/../fixtures';
    private const OUTDIR = __DIR__ . '/../data/compiled';

    public static function setUpBeforeClass()
    {
        Utils::rmDir(self::OUTDIR);
    }

    public function testCompile()
    {
        $compiler = new Compiler();
        $compiler->compile(__DIR__ . '/../fixtures/avsc/sample', self::OUTDIR);

        // verify folder structure
        $output = Utils::find(self::OUTDIR, '/.*/');
        $this->assertEquals([
            Utils::resolve(self::OUTDIR, 'Sample/User/UserEvent.php'),
            Utils::resolve(self::OUTDIR, 'Sample/Common/CommonEvent.php'),
            Utils::resolve(self::OUTDIR, 'Sample/Common/SharedMeta.php'),
            Utils::resolve(self::OUTDIR, 'BaseRecord.php'),
        ], $output);

    }

    public function testCompileBaseRecord()
    {
        $expected = file_get_contents(Utils::resolve(self::FIXTURES . "/expected/BaseRecord.php"));

        $compiler = new Compiler();
        $actual = $compiler->compileBaseRecord(self::NAMESPACE);

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

    public function provider() {
        return [
            ['ExampleEvent'],
            ['RecordWithArray'],
            ['RecordWithUnion'],
            ['RecordWithLogicalTypes'],
            ['RecordWithEnum'],
            ['RecordWithRecord'],
            ['Flavor', self::FIXTURES."/avsc/records/nested/"],
            ['ComplexRecord'],
            ['RecordWithMap'],
            ['RecordWithNestedMap']
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testCompileFile($recordName, $path = self::FIXTURES."/avsc/records/")
    {
        $avscPath = $path . "$recordName.avsc";

        $compiler = new Compiler();
        $actual = $compiler->compileFile($avscPath, self::NAMESPACE);
        $expected = file_get_contents(self::FIXTURES . "/expected/$recordName.php");

        $this->assertIsString($actual);
        $this->assertEquals($expected, $actual);
    }

}
