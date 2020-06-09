<?php

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use loophp\collection\Iterator\ClosureIterator;
use PhpSpec\ObjectBehavior;

class ClosureIteratorSpec extends ObjectBehavior
{
    public function it_can_be_constructed_with_a_callable_which_is_not_a_generator(): void
    {
        $callback = static function () {
            return range(1, 5);
        };

        $this
            ->beConstructedWith($callback);
    }

    public function it_can_get_a_key(): void
    {
        $callback = static function () {
            return range(1, 5);
        };

        $this
            ->beConstructedWith($callback);

        $this
            ->key()
            ->shouldReturn(0);
    }

    public function it_can_rewind()
    {
        $rdmString = static function () {
            yield 'foo';
        };

        $this
            ->beConstructedWith($rdmString);

        $this
            ->current()
            ->shouldReturn('foo');

        $this
            ->next();

        $this
            ->current()
            ->shouldReturn(null);

        $this
            ->rewind()
            ->shouldBeNull();
    }

    public function it_can_use_next(): void
    {
        $callback = static function () {
            return range(1, 5);
        };

        $this
            ->beConstructedWith($callback);

        $this
            ->next()
            ->shouldBeNull();

        $this
            ->current()
            ->shouldReturn(2);
    }

    public function it_is_initializable(): void
    {
        $callback = static function ($a, $b, $c) {
            yield $a;

            yield $b;

            yield $c;
        };

        $this
            ->beConstructedWith($callback, 'foo', 'bar', 'baz');

        $this->shouldHaveType(ClosureIterator::class);

        $this
            ->current()
            ->shouldBeEqualTo('foo');
    }
}
