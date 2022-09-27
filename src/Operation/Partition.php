<?php

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
final class Partition extends AbstractOperation
{
    /**
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

                yield new ClosureIteratorAggregate((new Filter())()(...$callbacks), [$iteratorAggregate]);

                yield new ClosureIteratorAggregate((new Reject())()(...$callbacks), [$iteratorAggregate]);
            };
    }
}
