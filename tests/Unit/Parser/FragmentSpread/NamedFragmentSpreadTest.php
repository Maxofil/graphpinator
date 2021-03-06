<?php

declare(strict_types = 1);

namespace Graphpinator\Tests\Unit\Parser\FragmentSpread;

final class NamedFragmentSpreadTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructor() : void
    {
        $val = new \Graphpinator\Parser\FragmentSpread\NamedFragmentSpread('fragment');
        self::assertSame('fragment', $val->getName());
        self::assertSame(\Graphpinator\Type\Introspection\DirectiveLocation::FRAGMENT_SPREAD, $val->getDirectives()->getLocation());
        self::assertCount(0, $val->getDirectives());
    }
}
