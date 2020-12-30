<?php

declare(strict_types=1);

namespace spec\loophp\collection\Operation;

use ArrayIterator;
use loophp\collection\Operation\Current;
use PhpSpec\ObjectBehavior;

class CurrentSpec extends ObjectBehavior
{
    public function it_can_get_current()
    {
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        $this
            ->__invoke()(0)($iterator)
            ->shouldIterateAs(['a']);

        $this
            ->__invoke()(0)($iterator)
            ->shouldHaveCount(1);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Current::class);
    }
}
