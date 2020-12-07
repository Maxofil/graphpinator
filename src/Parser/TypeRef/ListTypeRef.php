<?php

declare(strict_types = 1);

namespace Graphpinator\Parser\TypeRef;

final class ListTypeRef implements \Graphpinator\Parser\TypeRef\TypeRef
{
    use \Nette\SmartObject;

    public function __construct(
        private TypeRef $innerRef,
    ) {}

    public function getInnerRef() : TypeRef
    {
        return $this->innerRef;
    }

    public function normalize(\Graphpinator\Container\Container $typeContainer) : \Graphpinator\Type\ListType
    {
        return new \Graphpinator\Type\ListType($this->innerRef->normalize($typeContainer));
    }

    public function print() : string
    {
        return '[' . $this->innerRef->print() . ']';
    }
}
