<?php

declare(strict_types = 1);

namespace Graphpinator\Module\Upload;

final class UploadModule implements \Graphpinator\Module\Module
{
    use \Nette\SmartObject;

    private FileProvider $fileProvider;

    public function __construct(FileProvider $fileProvider)
    {
        $this->fileProvider = $fileProvider;
    }

    public function process(\Graphpinator\ParsedRequest $request) : \Graphpinator\ParsedRequest
    {
        $variables = $request->getVariables();

        foreach ($this->fileProvider->getMap() as $fileKey => $locations) {
            $fileValue = new \Graphpinator\Value\LeafValue(
                new \Graphpinator\Module\Upload\UploadType(),
                $this->fileProvider->getFile($fileKey),
            );

            foreach ($locations as $location) {
                /**
                 * Array reverse is done so we can use array_pop (O(1)) instead of array_shift (O(n))
                 */
                $keys = \array_reverse(\explode('.', $location));

                if (\array_pop($keys) !== 'variables') {
                    throw new \Nette\NotSupportedException;
                }

                $variableName = \array_pop($keys);
                $variable = $variables[$variableName];
                $variables[$variableName] = $this->insertFiles($keys, $variable, $variable->getType(), $fileValue);
            }
        }

        return $request;
    }

    private function insertFiles(
        array& $keys,
        \Graphpinator\Value\InputedValue $currentValue,
        \Graphpinator\Type\Contract\Definition $type,
        \Graphpinator\Value\LeafValue $fileValue
    ) : \Graphpinator\Value\InputedValue
    {
        if ($type instanceof \Graphpinator\Module\Upload\UploadType && $currentValue instanceof \Graphpinator\Value\NullValue) {
            if (empty($keys)) {
                return $fileValue;
            }

            throw new \Nette\NotSupportedException();
        }

        if ($type instanceof \Graphpinator\Type\NotNullType) {
            return $this->insertFiles($keys, $currentValue, $type->getInnerType(), $fileValue);
        }

        if ($type instanceof \Graphpinator\Type\ListType) {
            $index = \array_pop($keys);

            if (!\is_numeric($index)) {
                throw new \Nette\NotSupportedException();
            }

            $index = (int) $index;

            if ($currentValue instanceof \Graphpinator\Value\NullValue) {
                $currentValue = new \Graphpinator\Value\ListInputedValue($type, []);
            }

            if (!isset($currentValue[$index])) {
                $currentValue[$index] = new \Graphpinator\Value\NullInputedValue($type->getInnerType());
            }

            $currentValue[$index] = $this->insertFiles($keys, $currentValue[$index], $type->getInnerType(), $fileValue);

            return $currentValue;
        }

        if ($type instanceof \Graphpinator\Type\InputType && $currentValue instanceof \Graphpinator\Value\InputValue) {
            $index = \array_pop($keys);

            if (\is_numeric($index)) {
                throw new \Nette\NotSupportedException();
            }

            if ($currentValue instanceof \Graphpinator\Value\NullValue) {
                $currentValue = new \Graphpinator\Value\InputValue($type, new \stdClass());
            }

            // WIP

            if (!isset($currentValue->{$index})) {
                $currentValue->{$index} = new \Graphpinator\Value\NullInputedValue($type);
            }

            $currentValue->{$index} = $this->insertFiles($keys, $currentValue->{$index}->getValue(), $type->getInnerType(), $fileValue);

            // WIP

            return $currentValue;
        }

        throw new \Nette\NotSupportedException();
    }
}
