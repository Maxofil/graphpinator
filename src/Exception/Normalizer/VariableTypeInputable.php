<?php

declare(strict_types = 1);

namespace Graphpinator\Exception\Normalizer;

final class VariableTypeInputable extends \Graphpinator\Exception\Normalizer\NormalizerError
{
    public const MESSAGE = 'Variable type must be inputable type.';
}
