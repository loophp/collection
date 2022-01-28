<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\iterators\MultipleIterableAggregate;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Zip extends AbstractOperation
{
    /**
     * @pure
     *
     * @template UKey
     * @template U
     *
     * @return Closure(iterable<UKey, U>...): Closure(Iterator<TKey, T>): Generator<array<int, TKey|UKey|null>, array<int, T|U|null>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<UKey, U> ...$iterables
             *
             * @return Closure(Iterator<TKey, T>): Generator<array<int, TKey|UKey|null>, array<int, T|U|null>>
             */
            static fn (iterable ...$iterables): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<array<int, TKey|UKey|null>, array<int, T|U|null>>
                 */
                static fn (iterable $iterable): Generator => yield from new MultipleIterableAggregate([$iterable, ...array_values($iterables)], MultipleIterator::MIT_NEED_ANY);
    }
}
