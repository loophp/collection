<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Utils;

use Closure;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class CallbacksArrayReducer
{
    /**
     * @pure
     *
     * @return Closure(array<array-key, callable(T=, TKey=, iterable<TKey, T>=): bool>, T, TKey, iterable<TKey, T>): bool
     */
    public static function or(): Closure
    {
        return
            /**
             * @param array<array-key, callable(T=, TKey=, iterable<TKey, T>=): bool> $callbacks
             * @param T $current
             * @param TKey $key
             * @param iterable<TKey, T> $iterable
             */
            static fn (array $callbacks, $current, $key, iterable $iterable): bool => array_reduce(
                $callbacks,
                /**
                 * @param bool $carry
                 * @param callable(T=, TKey=, iterable<TKey, T>=): bool $callable
                 */
                static fn (bool $carry, callable $callable): bool => $carry || $callable($current, $key, $iterable),
                false
            );
    }
}
