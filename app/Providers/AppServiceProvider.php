<?php

namespace AvroToPhp\Providers;

use AvroToPhp\Compiler\Compiler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        Compiler::class
    ];
}
