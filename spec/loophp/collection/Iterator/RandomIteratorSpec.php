<?php

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use loophp\collection\Iterator\RandomIterator;
use PhpSpec\ObjectBehavior;

class RandomIteratorSpec extends ObjectBehavior
{
    public function it_can_get_the_innerIterator()
    {
        $this->getInnerIterator()->shouldBeAnInstanceOf(ArrayIterator::class);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RandomIterator::class);
    }

    public function let()
    {
        $iterator = new ArrayIterator(range(0, 4));

        $this->beConstructedWith($iterator);
    }
}
