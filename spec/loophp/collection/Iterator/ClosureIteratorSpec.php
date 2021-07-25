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
    private const LIST_DATA = [1, 2, 3];

    private const MAP_DATA = ['foo' => 1, 'bar' => 2];

    public function it_can_return_a_string_key(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [self::MAP_DATA]);

        $this->key()->shouldBe('foo');
        $this->next();
        $this->key()->shouldBe('bar');
    }

    public function it_can_return_an_int_key(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [self::LIST_DATA]);

        $this->key()->shouldBe(0);
        $this->next();
        $this->key()->shouldBe(1);
    }

    public function it_can_return_inner_iterator(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [self::LIST_DATA]);

        $this->getInnerIterator()->shouldIterateAs(self::LIST_DATA);
    }

    public function it_can_rewind(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [['foo']]);

        $this->current()->shouldBe('foo');

        $this->next();
        $this->valid()->shouldBe(false);
        $this->current()->shouldBeNull();

        $this->rewind();
        $this->valid()->shouldBe(true);
        $this->current()->shouldBe('foo');
    }

    public function it_is_initializable_from_callable_with_array(): void
    {
        $this->beConstructedWith(static fn (array $iterable): array => $iterable, [self::LIST_DATA]);

        $this->shouldHaveType(ClosureIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::LIST_DATA);
    }

    public function it_is_initializable_from_callable_with_generator(): void
    {
        $data = ['foo' => 1, 2];

        $this->beConstructedWith(static fn (array $iterable): Generator => yield from $iterable, [$data]);

        $this->shouldHaveType(ClosureIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs($data);
    }

    public function it_is_initializable_from_callable_with_iterator(): void
    {
        $this->beConstructedWith(static fn (array $iterable): Iterator => new ArrayIterator($iterable), [self::MAP_DATA]);

        $this->shouldHaveType(ClosureIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::MAP_DATA);
    }
}
