<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use const INF;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Range extends AbstractOperation
{
    /**
     * @psalm-return Closure(float=): Closure(float=): Closure(float=): Closure(null|Iterator<TKey, T>): Generator<int, float>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(float=): Closure(float=): Closure(null|Iterator<TKey, T>): Generator<int, float>
             */
            static function (float $start = 0.0): Closure {
                return
                    /**
                     * @psalm-return Closure(float=): Closure(null|Iterator<TKey, T>): Generator<int, float>
                     */
                    static function (float $end = INF) use ($start): Closure {
                        return
                            /**
                             * @psalm-return Closure(null|Iterator<TKey, T>): Generator<int, float>
                             */
                            static function (float $step = 1.0) use ($start, $end): Closure {
                                return
                                    /**
                                     * @psalm-param null|Iterator<TKey, T> $iterator
                                     * @psalm-return Generator<int, float>
                                     */
                                    static function (?Iterator $iterator = null) use ($start, $end, $step): Generator {
                                        for ($current = $start; $current < $end; $current += $step) {
                                            yield $current;
                                        }
                                    };
                            };
                    };
            };
    }
}
