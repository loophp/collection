<?php

declare(strict_types=1);

namespace spec\drupol\collection\Iterator;

use drupol\collection\Iterator\IterableIterator;
use PhpSpec\ObjectBehavior;

class IterableIteratorSpec extends ObjectBehavior
{
    public function it_can_be_constructed_with_a_callable_which_is_not_a_generator(): void
    {
        $this
            ->beConstructedWith(range(1, 5));
    }

    public function it_can_get_a_key(): void
    {
        $this
            ->beConstructedWith(range(1, 5));

        $this
            ->key()
            ->shouldReturn(0);
    }

    public function it_can_rewind()
    {
        $iterable = ['foo'];

        $this
            ->beConstructedWith($iterable);

        $this
            ->current()
            ->shouldReturn('foo');

        $this
            ->next()
            ->current()
            ->shouldReturn(null);

        $this
            ->rewind()
            ->current()
            ->shouldReturn('foo');
    }

    public function it_can_use_next(): void
    {
        $this
            ->beConstructedWith(range(1, 5));

        $this
            ->next()
            ->shouldReturn($this);

        $this
            ->current()
            ->shouldReturn(2);
    }

    public function it_is_initializable(): void
    {
        $iterable = ['foo', 'bar', 'baz'];

        $this
            ->beConstructedWith($iterable);

        $this->shouldHaveType(IterableIterator::class);

        $this
            ->current()
            ->shouldBeEqualTo('foo');
    }
}
