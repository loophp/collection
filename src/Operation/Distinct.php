<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use loophp\iterators\InterruptableIterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Distinct extends AbstractOperation
{
    /**
     * @template U
     *
     * @return Closure(callable(U): Closure(U): bool): Closure(callable(T, TKey): U): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(U): (Closure(U): bool) $comparatorCallback
             *
             * @return Closure(callable(T, TKey): U): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $comparatorCallback): Closure =>
                /**
                 * @param callable(T, TKey): U $accessorCallback
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                 */
                static function (callable $accessorCallback) use ($comparatorCallback): Closure {
                    return static function (int $retries) use ($accessorCallback, $comparatorCallback): Closure {
                        return static function (iterable $iterable) use ($comparatorCallback, $accessorCallback, $retries): Generator {
                            /** @var ArrayIterator<int, array{0: TKey, 1: T}> $stack */
                            $stack = new ArrayIterator();

                            $filter = static function (array $kvFilter, Generator $generator) use ($comparatorCallback, $accessorCallback, $stack, &$retries): bool {
                                if (0 >= $retries) {
                                    $generator->send(InterruptableIterableIteratorAggregate::BREAK);
                                }

                                $every = (new Every())()(
                                    /**
                                     * @param array{0: TKey, 1: T} $kvEvery
                                     */
                                    static fn (int $_, array $kvEvery): bool => !$comparatorCallback($accessorCallback($kvFilter[1], $kvFilter[0]))($accessorCallback($kvEvery[1], $kvEvery[0]))
                                )($stack);

                                if (false === $every->current()) {
                                    --$retries;

                                    return false;
                                }

                                ++$retries;
                                $stack->append($kvFilter);

                                return true;
                            };

                            return (new Pipe())()(
                                (new Filter())()($filter),
                                (new Unpack())()
                            )(new InterruptableIterableIteratorAggregate($iterable));
                        };
                    };
                };
    }
}
