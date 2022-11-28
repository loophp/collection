<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;
use Traversable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Product extends AbstractOperation
{
    /**
     * @template UKey
     * @template U
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<UKey, U> ...$iterables
             *
             * @return Closure(iterable<TKey, T>): Generator<int, array<array-key, T|U>>
             */
            static function (iterable ...$iterables): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<int, list<T|U>> $pipe */
                $pipe = (new Pipe())()(
                    (
                        /**
                         * @param array<int, Traversable<UKey, U>> $iterables
                         */
                        static fn (array $iterables): Closure =>
                        /**
                         * @param iterable<TKey, T> $iterable
                         */
                        static fn (iterable $iterable): Generator => (
                            /**
                             * @param Closure(iterable<TKey, T>): (Closure(iterable<UKey, U>): Generator<array<array-key, T|U>>) $f
                             */
                            static fn (Closure $f): Closure => (new FoldLeft())()(
                                /**
                                 * @param iterable<UKey, U> $a
                                 * @param iterable<TKey, T> $x
                                 */
                                static fn (iterable $a, iterable $x): Generator => $f($x)($a)
                            )
                        )(
                            /**
                             * @param (iterable<TKey, T>|iterable<UKey, U>) $xs
                             */
                            static fn (iterable $xs): Closure =>
                                /**
                                 * @param iterable<int, array<array-key, T>> $as
                                 */
                                static fn (iterable $as): Generator => (new FlatMap())()(
                                    /**
                                     * @param array<int, T> $a
                                     */
                                    static fn (array $a): Generator => (new FlatMap())()(
                                        /**
                                         * @param T|U $x
                                         *
                                         * @return Generator<int, array<array-key, T|U>>
                                         */
                                        static fn (mixed $x): Generator => yield [...$a, $x]
                                    )($xs)
                                )($as)
                        )([[]])([$iterable, ...$iterables])
                    )(
                        array_map(
                            /**
                             * @param iterable<UKey, U> $iterable
                             *
                             * @return IterableIteratorAggregate<UKey, U>
                             */
                            static fn (iterable $iterable): IterableIteratorAggregate => new IterableIteratorAggregate($iterable),
                            $iterables
                        )
                    ),
                    ((new Unwrap())()),
                    ((new Normalize())())
                );

                // Point free style.
                return $pipe;
            };
    }
}
