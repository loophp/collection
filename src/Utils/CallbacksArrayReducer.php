<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Utils;

use Closure;
use Iterator;

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
     * @return Closure(list<callable(T=, TKey=, Iterator<TKey, T>=): bool>, T, TKey, Iterator<TKey, T>): bool
     */
    public static function or(): Closure
    {
        return
            /**
             * @param list<callable(T=, TKey=, Iterator<TKey, T>=): bool> $callbacks
             * @param T $current
             * @param TKey $key
             * @param Iterator<TKey, T> $iterator
             */
            static fn (array $callbacks, $current, $key, Iterator $iterator): bool => array_reduce(
                $callbacks,
                /**
                 * @param bool $carry
                 * @param callable(T=, TKey=, Iterator<TKey, T>=): bool $callable
                 */
                static fn (bool $carry, callable $callable): bool => $carry || $callable($current, $key, $iterator),
                false
            );
    }
}
