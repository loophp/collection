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
use loophp\iterators\ConcatIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Prepend extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(T...): Closure(Iterator<TKey, T>): Iterator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$items
             *
             * @return Closure(Iterator<TKey, T>): Iterator<int|TKey, T>
             */
            static fn (...$items): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Generator<int|TKey, T>
                 */
                static fn (Iterator $iterator): Generator => yield from new ConcatIterableAggregate([$items, $iterator]);
    }
}
