<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Generator;
use loophp\collection\Iterator\MultipleIterableIterator;
use PhpSpec\ObjectBehavior;

class MultipleIterableIteratorSpec extends ObjectBehavior
{
    public function it_can_iterate_with_multiple_iterables(): void
    {
        $this->beConstructedWith([1, 2, 3], new ArrayIterator([4, 5, 6]));

        $expected = static function (): Generator {
            yield 0 => 1;

            yield 1 => 2;

            yield 2 => 3;

            yield 0 => 4;

            yield 1 => 5;

            yield 2 => 6;
        };

        $this->shouldIterateAs($expected());
    }

    public function it_is_initializable_with_a_single_iterable(): void
    {
        $this->beConstructedWith([1, 2, 3]);

        $this->shouldHaveType(MultipleIterableIterator::class);
    }

    public function it_is_initializable_with_multiple_iterables(): void
    {
        $this->beConstructedWith([1, 2, 3], new ArrayIterator([4, 5, 6]));

        $this->shouldHaveType(MultipleIterableIterator::class);
    }
}
