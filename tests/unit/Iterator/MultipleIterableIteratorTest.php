<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection\Iterator;

use ArrayIterator;
use Generator;
use loophp\collection\Iterator\MultipleIterableIterator;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\collection\Iterator
 */
final class MultipleIterableIteratorTest extends TestCase
{
    use IterableAssertions;

    public function testIterateWithASingleIterable(): void
    {
        $iterator = new MultipleIterableIterator([1, 2, 3]);

        self::assertIdenticalIterable(
            [1, 2, 3],
            $iterator
        );
    }

    public function testIterateWithMultipleIterables(): void
    {
        $iterator = new MultipleIterableIterator([1, 2, 3], new ArrayIterator([4, 5, 6]));

        $expected = static function (): Generator {
            yield 0 => 1;

            yield 1 => 2;

            yield 2 => 3;

            yield 0 => 4;

            yield 1 => 5;

            yield 2 => 6;
        };

        self::assertIdenticalIterable(
            $expected(),
            $iterator
        );
    }
}
