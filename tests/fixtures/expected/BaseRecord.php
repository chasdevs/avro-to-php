<?php

namespace Tests\Expected;

use JsonSerializable;

abstract class BaseRecord implements JsonSerializable
{
    public function data(): array {
        return $this->encode($this);
    }

    protected function encode($mixed) {
        return json_decode(json_encode($mixed), true);
    }
}