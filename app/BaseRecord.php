<?php

namespace App;

abstract class BaseRecord
{
    public abstract function subject(): string;
    public abstract function data(): array;
}