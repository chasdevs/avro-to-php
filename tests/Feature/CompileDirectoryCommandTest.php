<?php

namespace Tests\Feature;

use App\Util\Utils;
use Tests\TestCase;

class CompileDirectoryCommandTest extends TestCase
{
    public function testCompileDirectory()
    {
        $sourceDir = Utils::resolve(__DIR__, '../fixtures/avsc');
        $dataDir = Utils::resolve(__DIR__, '../data');
        $this->artisan("compile {$sourceDir} {$dataDir}/command-output -d")
             ->assertExitCode(0);
    }

    public function testCompileDirectoryWithNamespace()
    {
        $sourceDir = Utils::resolve(__DIR__, '../fixtures/avsc');
        $dataDir = Utils::resolve(__DIR__, '../data');
        $this->artisan("compile {$sourceDir} {$dataDir}/command-output --namespace Bob -d")
             ->assertExitCode(0);
    }
}
