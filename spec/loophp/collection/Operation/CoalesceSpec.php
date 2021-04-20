<?php

declare(strict_types=1);

namespace spec\loophp\collection\Operation;

use ArrayIterator;
use loophp\collection\Operation\Coalesce;
use PhpSpec\ObjectBehavior;

class CoalesceSpec extends ObjectBehavior
{
    public function it_can_coalesce()
    {
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        $this
            ->__invoke()($iterator)
            ->shouldHaveCount(1);

        $this
            ->__invoke()($iterator)
            ->shouldIterateAs([
                0 => 'a',
            ]);

        $input = ['', null, 'foo', false, ...range('a', 'e')];

        $iterator = new ArrayIterator($input);

        $this
            ->__invoke()($iterator)
            ->shouldHaveCount(1);

        $this
            ->__invoke()($iterator)
            ->shouldIterateAs([
                2 => 'foo',
            ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Coalesce::class);
    }
}
