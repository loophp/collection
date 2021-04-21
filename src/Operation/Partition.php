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
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Partition extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>):bool...): Closure(Iterator<TKey, T>): Generator<int, list<array{0: TKey, 1: T}>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>):bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<array{0: TKey, 1: T}>>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<int, list<array{0: TKey, 1: T}>>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $reducerCallback =
                        /**
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $current
                             * @psalm-param T $current
                             *
                             * @psalm-return Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                             */
                            static fn ($current): Closure =>
                                /**
                                 * @psalm-param Iterator<TKey, T> $iterator
                                 *
                                 * @psalm-return Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                 */
                                static fn (Iterator $iterator): Closure =>
                                    /**
                                     * @psalm-param bool $carry
                                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callable
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
