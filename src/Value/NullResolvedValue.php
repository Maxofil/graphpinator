<?php

declare(strict_types = 1);

namespace Graphpinator\Value;

final class NullResolvedValue implements OutputValue, NullValue
{
    use \Nette\SmartObject;

    protected \Graphpinator\Type\Contract\Resolvable $type;

    public function __construct(\Graphpinator\Type\Contract\Resolvable $type)
    {
        $this->type = $type;
    }

    /** @return null */
    public function getRawValue()
    {
        return null;
    }

    public function getType() : \Graphpinator\Type\Contract\Resolvable
    {
        return $this->type;
    }

    /** @return null */
    public function jsonSerialize()
    {
        return null;
    }

    public function printValue() : string
    {
        return 'null';
    }
}