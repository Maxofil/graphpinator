<?php

declare(strict_types = 1);

namespace Graphpinator\Directive;

final class ExecutableDirectiveLocation
{
    use \Nette\StaticClass;

    public const QUERY = 'QUERY'; // currently not supported
    public const MUTATION = 'MUTATION'; // currently not supported
    public const SUBSCRIPTION = 'SUBSCRIPTION'; // currently not supported
    public const FIELD = 'FIELD';
    public const FRAGMENT_DEFINITION = 'FRAGMENT_DEFINITION'; // currently not supported
    public const FRAGMENT_SPREAD = 'FRAGMENT_SPREAD';
    public const INLINE_FRAGMENT = 'INLINE_FRAGMENT';
    public const VARIABLE_DEFINITION = 'VARIABLE_DEFINITION'; // currently not supported
}
