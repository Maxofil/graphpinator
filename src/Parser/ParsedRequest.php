<?php

declare(strict_types = 1);

namespace Graphpinator\Parser;

final class ParsedRequest
{
    use \Nette\SmartObject;

    public function __construct(
        private \Graphpinator\Parser\Operation\OperationSet $operations,
        private \Graphpinator\Parser\Fragment\FragmentSet $fragments,
    ) {}

    public function getOperations() : \Graphpinator\Parser\Operation\OperationSet
    {
        return $this->operations;
    }

    public function getFragments() : \Graphpinator\Parser\Fragment\FragmentSet
    {
        return $this->fragments;
    }

    public function normalize(\Graphpinator\Type\Schema $schema) : \Graphpinator\Normalizer\NormalizedRequest
    {
        foreach ($this->fragments as $fragment) {
            $fragment->validateCycles($this->fragments, []);
        }

        return new \Graphpinator\Normalizer\NormalizedRequest($this->operations->normalize($schema, $this->fragments));
    }
}
