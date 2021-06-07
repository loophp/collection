<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Generator;
use Iterator;
use loophp\collection\Iterator\ClosureIterator;
use PhpSpec\ObjectBehavior;

class ClosureIteratorSpec extends ObjectBehavior
{
    public function it_can_return_a_string_key(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, ['foo' => 1, 'bar' => 2]);

        $this->key()->shouldBe('foo');
        $this->next();
        $this->key()->shouldBe('bar');
    }

    public function it_can_return_an_int_key(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [1, 2, 3]);

        $this->key()->shouldBe(0);
        $this->next();
        $this->key()->shouldBe(1);
    }

    public function it_can_rewind(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, ['foo']);

        $this->current()->shouldBe('foo');
        $this->next();
        $this->current()->shouldBeNull();

        $this->rewind();
        $this->current()->shouldBe('foo');
    }

    public function it_is_initializable_from_callable_with_array(): void
    {
        $this->beConstructedWith(static fn (array $iterable): array => $iterable, [1, 2, 3]);

        $this->shouldHaveType(ClosureIterator::class);

        $this->valid()->shouldBe(true);
        $this->current()->shouldBe(1);
    }

    public function it_is_initializable_from_callable_with_generator(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [1, 2, 3]);

        $this->shouldHaveType(ClosureIterator::class);

        $this->valid()->shouldBe(true);
        $this->current()->shouldBe(1);
    }

    public function it_is_initializable_from_callable_with_iterator(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Iterator => new ArrayIterator($iterable), [1, 2, 3]);

        $this->shouldHaveType(ClosureIterator::class);

        $this->valid()->shouldBe(true);
        $this->current()->shouldBe(1);
    }
}
