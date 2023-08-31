<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use const INF;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Range extends AbstractOperation
{
    /**
     * @return Closure(int|float=): Closure(int|float=): Closure(int|float=): Closure(): Generator<int, int|float>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(int|float=): Closure(int|float=): Closure(): Generator<int, int|float>
             */
            static fn (int|float $start = 0.0): Closure =>
                /**
                 * @return Closure(int|float=): Closure(): Generator<int, int|float>
                 */
                static fn (int|float $end = INF): Closure =>
                    /**
                     * @return Closure(): Generator<int, int|float>
                     */
                    static fn (int|float $step = 1.0): Closure =>
                        /**
                         * @return Generator<int, int|float>
                         */
                        static function () use ($start, $end, $step): Generator {
                            for ($current = $start; $current < $end; $current += $step) {
                                yield (($intCurrent = (int) $current) === $current) ? $intCurrent : $current;
                            }
                        };
    }
}
