<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use InfiniteIterator;
use loophp\iterators\ConcatIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Intersperse extends AbstractOperation
{
    /**
     * @return Closure(T): Closure(int): Closure(int): Closure(iterable<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T $element
             *
             * @return Closure(int): Closure(int): Closure(iterable<TKey, T>): Generator<int|TKey, T>
             */
            static fn ($element): Closure =>
                /**
                 * @return Closure(int): Closure(iterable<TKey, T>): Generator<int|TKey, T>
                 */
                static fn (int $atEvery): Closure =>
                    /**
                     * @return Closure(iterable<TKey, T>): Generator<int|TKey, T>
                     */
                    static fn (int $startAt): Closure =>
                        /**
                         * @param iterable<TKey, T> $iterable
                         *
                         * @return Generator<int|TKey, T>
                         */
                        static function (iterable $iterable) use ($element, $atEvery, $startAt): Generator {
                            $intersperse = (new ConcatIterableAggregate([
                                new ArrayIterator(array_fill(0, $startAt, 1)),
                                new InfiniteIterator(new ArrayIterator(range(0, $atEvery - 1))),
                            ]))->getIterator();

                            foreach ($iterable as $key => $value) {
                                if (0 === $intersperse->current()) {
                                    yield $element;
                                }

                                yield $key => $value;

                                $intersperse->next();
                            }
                        };
    }
}
