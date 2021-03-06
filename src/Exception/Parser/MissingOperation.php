<?php

declare(strict_types = 1);

namespace Graphpinator\Exception\Parser;

final class MissingOperation extends \Graphpinator\Exception\Parser\ParserError
{
    public const MESSAGE = 'No GraphQL operation requested.';
}
