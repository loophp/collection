<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\LimitIterableAggregate;
use loophp\iterators\RandomIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Random extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(int): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(int): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static function (int $seed): Closure {
                return
                    /**
                     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                     */
                    static function (int $size) use ($seed): Closure {
                        return
                            /**
                             * @param iterable<TKey, T> $iterable
                             *
                             * @return Generator<TKey, T>
                             */
                            static function (iterable $iterable) use ($seed, $size): Generator {
                                // Point free style.
                                yield from new LimitIterableAggregate(new RandomIterableAggregate($iterable, $seed), 0, $size);
                            };
                    };
            };
    }
}
