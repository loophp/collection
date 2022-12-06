<?php

declare(strict_types=1);

namespace loophp\collection\Utils;

use Closure;

/**
 * @internal
 *
 * @immutable
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
            static fn (array $callbacks): Closure => static fn (mixed ...$parameters): bool => array_reduce(
                $callbacks,
                /**
                 * @param callable(mixed...): bool $callable
                 */
                static fn (bool $carry, callable $callable): bool => $carry || $callable(...$parameters),
                false
            );
    }
}
