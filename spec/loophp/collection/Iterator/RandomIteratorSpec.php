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

    public function it_can_rewind()
    {
        $iterator = new ArrayIterator(['a']);

        $this->beConstructedWith($iterator);

        $this
            ->valid()
            ->shouldReturn(true);

        $this
            ->current()
            ->shouldReturn('a');

        $this->next();

        $this
            ->valid()
            ->shouldReturn(false);

        $this
            ->rewind();

        $this
            ->valid()
            ->shouldReturn(true);

        $this
            ->current()
            ->shouldReturn('a');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RandomIterator::class);
    }

    public function let()
    {
        $iterator = new ArrayIterator(range('a', 'c'));

        $this->beConstructedWith($iterator);
    }
}
