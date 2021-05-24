<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Generator;
use loophp\collection\Iterator\IterableIterator;
use PhpSpec\ObjectBehavior;

class IterableIteratorSpec extends ObjectBehavior
{
    public function it_can_get_a_string_key(): void
    {
        $this->beConstructedWith(['foo' => 1, 'bar' => 2]);

        $this->key()->shouldReturn('foo');
        $this->next();
        $this->key()->shouldReturn('bar');
    }

    public function it_can_get_an_int_key(): void
    {
        $this->beConstructedWith(range(1, 5));

        $this->key()->shouldReturn(0);
        $this->next();
        $this->key()->shouldReturn(1);
    }

    public function it_can_rewind(): void
    {
        $this->beConstructedWith(['foo']);

        $this->current()->shouldReturn('foo');

        $this->next();
        $this->current()->shouldReturn(null);

        $this->rewind();
        $this->current()->shouldReturn('foo');
    }

    public function it_can_use_next(): void
    {
        $this->beConstructedWith(range(1, 5));

        $this->next()->shouldBeNull();

        $this->current()->shouldReturn(2);
    }

    public function it_is_initializable_from_array(): void
    {
        $this->beConstructedWith(['foo', 'bar', 'baz']);

        $this->shouldHaveType(IterableIterator::class);

        $this->current()->shouldBeEqualTo('foo');
    }

    public function it_is_initializable_from_generator(): void
    {
        $gen = static fn (): Generator => yield from ['foo', 'bar', 'baz'];

        $this->beConstructedWith($gen());

        $this->shouldHaveType(IterableIterator::class);

        $this->current()->shouldBeEqualTo('foo');
    }

    public function it_is_initializable_from_iterator(): void
    {
        $this->beConstructedWith(new ArrayIterator(['foo', 'bar', 'baz']));

        $this->shouldHaveType(IterableIterator::class);

        $this->current()->shouldBeEqualTo('foo');
    }
}
