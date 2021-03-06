<?php

declare(strict_types = 1);

namespace Graphpinator\Type;

final class NotNullType extends \Graphpinator\Type\Contract\ModifierDefinition
{
    public function createInputedValue($rawValue) : \Graphpinator\Value\InputedValue
    {
        \assert($this->innerType instanceof \Graphpinator\Type\Contract\Inputable);
        $value = $this->innerType->createInputedValue($rawValue);

        if ($value instanceof \Graphpinator\Value\NullValue) {
            throw new \Graphpinator\Exception\Value\ValueCannotBeNull(true);
        }

        return $value;
    }

    public function createResolvedValue(mixed $rawValue) : \Graphpinator\Value\ResolvedValue
    {
        \assert($this->innerType instanceof \Graphpinator\Type\Contract\Outputable);
        $value = $this->innerType->createResolvedValue($rawValue);

        if ($value instanceof \Graphpinator\Value\NullValue) {
            throw new \Graphpinator\Exception\Value\ValueCannotBeNull(false);
        }

        return $value;
    }

    public function resolve(
        ?\Graphpinator\Normalizer\Field\FieldSet $requestedFields,
        \Graphpinator\Value\ResolvedValue $parentResult
    ) : \Graphpinator\Value\ResolvedValue
    {
        \assert($this->innerType instanceof \Graphpinator\Type\Contract\Resolvable);

        return $this->innerType->resolve($requestedFields, $parentResult);
    }

    public function isInstanceOf(\Graphpinator\Type\Contract\Definition $type) : bool
    {
        if ($type instanceof self) {
            return $this->innerType->isInstanceOf($type->getInnerType());
        }

        return false;
    }

    public function getTypeKind() : string
    {
        return \Graphpinator\Type\Introspection\TypeKind::NON_NULL;
    }

    public function printName() : string
    {
        return $this->innerType->printName() . '!';
    }

    public function getShapingType() : \Graphpinator\Type\Contract\Definition
    {
        return $this->getInnerType();
    }
}
