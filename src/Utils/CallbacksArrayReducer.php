<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Utils;

use Closure;

/**
 * @internal
 *
 * @immutable
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class CallbacksArrayReducer
{
    /**
     * @return Closure(array<array-key, callable(mixed...): bool>): Closure(mixed...): bool
     */
    public static function or(): Closure
    {
        return
            /**
             * @param array<array-key, callable(mixed...): bool> $callbacks
             *
             * @return Closure(mixed...): bool
             */
            static fn (array $callbacks): Closure =>
                /**
                 * @param mixed ...$parameters
                 */
                static fn (...$parameters): bool => array_reduce(
                    $callbacks,
                    /**
                     * @param bool $carry
                     * @param callable(mixed...): bool $callable
                     */
                    static fn (bool $carry, callable $callable): bool => $carry || $callable(...$parameters),
                    false
                );
    }
}
