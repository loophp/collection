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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Range extends AbstractOperation
{
    /**
     * @return Closure(float=): Closure(float=): Closure(float=): Closure(): Generator<int, float>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(float=): Closure(float=): Closure(): Generator<int, float>
             */
            static fn (float $start = 0.0): Closure =>
                /**
                 * @return Closure(float=): Closure(): Generator<int, float>
                 */
                static fn (float $end = INF): Closure =>
                    /**
                     * @return Closure(): Generator<int, float>
                     */
                    static fn (float $step = 1.0): Closure =>
                        /**
                         * @return Generator<int, float>
                         */
                        static function () use ($start, $end, $step): Generator {
                            for ($current = $start; $current < $end; $current += $step) {
                                yield $current;
                            }
                        };
    }
}
