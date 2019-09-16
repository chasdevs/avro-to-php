<?php

namespace Tests\Expected;

use MyCLabs\Enum\Enum;

/**
 * @method static Flavor VANILLA()
 * @method static Flavor CHOCOLATE()
 * @method static Flavor STRAWBERRY()
 */
class Flavor extends Enum
{
    private const VANILLA = 'VANILLA';
    private const CHOCOLATE = 'CHOCOLATE';
    private const STRAWBERRY = 'STRAWBERRY';
}