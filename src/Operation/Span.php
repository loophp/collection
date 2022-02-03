<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\CachingIteratorAggregate;
use loophp\iterators\ClosureIteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Span extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): bool ...): Closure(iterable<TKey, T>): Generator<int, iterable<TKey, T>>
     */
    public function __invoke(): Closure
    {
        /**
         * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
         *
         * @return Closure(iterable<TKey, T>): Generator<int, iterable<TKey, T>>
         */
        return static fn (callable ...$callbacks): Closure =>
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, iterable<TKey, T>>
             */
            static function (iterable $iterable) use ($callbacks): Generator {
                $iteratorAggregate = (new CachingIteratorAggregate((new IterableIteratorAggregate($iterable))->getIterator()));

                yield new ClosureIteratorAggregate((new TakeWhile())()(...$callbacks), [$iteratorAggregate]);

                yield new ClosureIteratorAggregate((new DropWhile())()(...$callbacks), [$iteratorAggregate]);
            };
    }
}
