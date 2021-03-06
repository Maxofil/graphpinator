<?php

declare(strict_types = 1);

namespace Graphpinator\Type\Addon;

class RgbInput extends \Graphpinator\Type\InputType
{
    protected const NAME = 'RgbInput';
    protected const DESCRIPTION = 'Rgb input - input for the RGB color model.';

    protected function getFieldDefinition() : \Graphpinator\Argument\ArgumentSet
    {
        return new \Graphpinator\Argument\ArgumentSet([
            (new \Graphpinator\Argument\Argument(
                'red',
                \Graphpinator\Container\Container::Int()->notNull(),
            ))->addConstraint(new \Graphpinator\Constraint\IntConstraint(0, 255)),
            (new \Graphpinator\Argument\Argument(
                'green',
                \Graphpinator\Container\Container::Int()->notNull(),
            ))->addConstraint(new \Graphpinator\Constraint\IntConstraint(0, 255)),
            (new \Graphpinator\Argument\Argument(
                'blue',
                \Graphpinator\Container\Container::Int()->notNull(),
            ))->addConstraint(new \Graphpinator\Constraint\IntConstraint(0, 255)),
        ]);
    }
}
