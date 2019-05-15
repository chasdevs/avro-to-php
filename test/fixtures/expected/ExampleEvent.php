<?php

namespace Storyblocks\Example;

class ExampleEvent
{

    /** @var string */
    private $name;

    /** @var bool */
    private $active;

    /** @var int */
    private $salary;

    public function setName(string $name): ExampleEvent
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setActive(bool $active): ExampleEvent
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setSalary(int $salary): ExampleEvent
    {
        $this->salary = $salary;
        return $this;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public const schema = <<<SCHEMA
{
    "type": "record",
    "name": "ExampleEvent",
    "namespace": "storyblocks.example",
    "doc": "This is an example schema.",
    "fields": [
        {
            "name": "name",
            "type": "string"
        },
        {
            "name": "active",
            "type": "boolean",
            "default": true
        },
        {
            "name": "salary",
            "type": "long"
        }
    ]
}
SCHEMA;

}