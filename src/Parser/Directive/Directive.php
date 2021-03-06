<?php

declare(strict_types = 1);

namespace Graphpinator\Parser\Directive;

final class Directive
{
    use \Nette\SmartObject;

    public function __construct(
        private string $name,
        private string $location,
        private ?\Graphpinator\Parser\Value\ArgumentValueSet $arguments,
    ) {}

    public function getName() : string
    {
        return $this->name;
    }

    public function getLocation() : string
    {
        return $this->location;
    }

    public function getArguments() : ?\Graphpinator\Parser\Value\ArgumentValueSet
    {
        return $this->arguments;
    }
}
