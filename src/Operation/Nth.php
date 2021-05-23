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

/**
 * @template TKey of array-key
 * @template T
 */
final class Nth extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (int $step): Closure =>
                /**
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static function (int $offset) use ($step): Closure {
                    $filterCallback =
                        /**
                         * @psalm-param array{0: TKey, 1: T} $value
                         */
                        static fn (array $value, int $key): bool => (($key % $step) === $offset);

                    /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = Pipe::of()(
                        Pack::of(),
                        Filter::of()($filterCallback),
                        Unpack::of()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
