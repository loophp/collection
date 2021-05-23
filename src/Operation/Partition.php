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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Partition extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey, Iterator<TKey, T>):bool...): Closure(Iterator<TKey, T>): Generator<int, list<array{0: TKey, 1: T}>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, Iterator<TKey, T>):bool ...$callbacks
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, list<array{0: TKey, 1: T}>>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Generator<int, list<array{0: TKey, 1: T}>>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $reducerCallback =
                        /**
                         * @param TKey $key
                         *
                         * @return Closure(T): Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param T $current
                             *
                             * @return Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                             */
                            static fn ($current): Closure =>
                                /**
                                 * @param Iterator<TKey, T> $iterator
                                 *
                                 * @return Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                 */
                                static fn (Iterator $iterator): Closure =>
                                    /**
                                     * @param bool $carry
                                     * @param callable(T, TKey, Iterator<TKey, T>): bool $callable
                                     */
                                    static fn (bool $carry, callable $callable): bool => $carry || $callable($current, $key, $iterator);

                    $true = $false = [];

                    foreach ($iterator as $key => $current) {
                        $result = array_reduce(
                            $callbacks,
                            $reducerCallback($key)($current)($iterator),
                            false
                        );

                        $result ?
                            $true[] = [$key, $current] :
                            $false[] = [$key, $current];
                    }

                    yield $true;

                    return yield $false;
                };
    }
}
