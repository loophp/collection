<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Generator;
use InvalidArgumentException;
use loophp\collection\Iterator\TypedIterator;
use PhpSpec\ObjectBehavior;

class TypedIteratorSpec extends ObjectBehavior
{
    private const LIST_DATA = [1, 2, 3];

    private const MAP_DATA = ['foo' => 1, 'bar' => 2];

    public function it_allows_null_type(): void
    {
        $data = [1, null, 3];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_can_return_a_string_key(): void
    {
        $this->beConstructedWith(self::MAP_DATA);

        $this->key()->shouldBe('foo');
        $this->next();
        $this->key()->shouldBe('bar');
    }

    public function it_can_return_an_int_key(): void
    {
        $this->beConstructedWith(self::LIST_DATA);

        $this->key()->shouldBe(0);
        $this->next();
        $this->key()->shouldBe(1);
    }

    public function it_can_rewind(): void
    {
        $this->beConstructedWith(['foo']);

        $this->current()->shouldBe('foo');

        $this->next();
        $this->valid()->shouldBe(false);
        $this->current()->shouldBeNull();

        $this->rewind();
        $this->valid()->shouldBe(true);
        $this->current()->shouldBe('foo');
    }

    public function it_disallows_bool_mixed(): void
    {
        $this->beConstructedWith([true, false, 'bar']);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_float_mixed(): void
    {
        $this->beConstructedWith([2.3, 5.6, 1]);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_int_mixed(): void
    {
        $this->beConstructedWith([1, 2, 'foo']);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_mixed_at_beginning(): void
    {
        $this->beConstructedWith([1, 'bar', 'foo']);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_mixed_in_middle(): void
    {
        $this->beConstructedWith([1, 'bar', 2]);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_string_mixed(): void
    {
        $this->beConstructedWith(['foo', 'bar', 3]);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_is_initializable_from_array(): void
    {
        $this->beConstructedWith(self::LIST_DATA);

        $this->shouldHaveType(TypedIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::LIST_DATA);
    }

    public function it_is_initializable_from_generator(): Generator
    {
        $this->beConstructedWith(yield from self::MAP_DATA);

        $this->shouldHaveType(TypedIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::MAP_DATA);
    }

    public function it_is_initializable_from_iterator(): void
    {
        $this->beConstructedWith(new ArrayIterator(self::LIST_DATA));

        $this->shouldHaveType(TypedIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::LIST_DATA);
    }
}
