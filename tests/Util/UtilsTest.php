<?php

namespace Tests\Util;

use AvroToPhp\Util\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase {

    public function testJoinPaths()
    {
        $expected = 'one'.DIRECTORY_SEPARATOR.'two'.DIRECTORY_SEPARATOR.'three'.DIRECTORY_SEPARATOR.'four';
        $actual = Utils::joinPaths('one', '/two/three', 'four');
        $this->assertEquals($expected, $actual);

        $expected = realpath(__DIR__ . '/..');
        $actual = Utils::resolve(__DIR__, '..');
        $this->assertEquals($expected, $actual);
    }

    public function testRsearch() {
        $results = Utils::find(__DIR__ . '/../fixtures/sampleUtilDir', '/.*.txt/');
        $this->assertEquals([Utils::resolve(__DIR__, '../fixtures/sampleUtilDir/dummy.txt')], $results);
    }

    public function testDirCreateRm() {
        $file = __DIR__ . '/../data/test-util/a-directory/file.txt';
        $dir = dirname($file);
        Utils::ensureDir($file);
        $this->assertDirectoryExists($dir);
        Utils::rmDir($dir);
        $this->assertDirectoryDoesNotExist($dir);
    }

}
