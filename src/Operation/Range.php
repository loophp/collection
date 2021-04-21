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
     * @psalm-return Closure(float  = default):Closure (float=): Closure(float=): Closure(null|Iterator<TKey, T>): Generator<int, float>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(float=): Closure(float=): Closure(null|Iterator<TKey, T>): Generator<int, float>
             */
            static fn (float $start = 0.0): Closure =>
                /**
                 * @psalm-return Closure(float=): Closure(null|Iterator<TKey, T>): Generator<int, float>
                 */
                static fn (float $end = INF): Closure =>
                    /**
                     * @psalm-return Closure(null|Iterator<TKey, T>): Generator<int, float>
                     */
                    static fn (float $step = 1.0): Closure =>
                        /**
                         * @psalm-param null|Iterator<TKey, T> $iterator
                         *
                         * @psalm-return Generator<int, float>
                         */
                        static function (?Iterator $iterator = null) use ($start, $end, $step): Generator {
                            for ($current = $start; $current < $end; $current += $step) {
                                yield $current;
                            }
                        };
    }
}
