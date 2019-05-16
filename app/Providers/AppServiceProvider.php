<?php

namespace App\Providers;

use App\Compiler\Compiler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        Compiler::class
    ];
}
