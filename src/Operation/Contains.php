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
final class Contains extends AbstractOperation
{
    /**
     * @return Closure(T...): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$values
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (...$values): Closure {
                $callback =
                    /**
                     * @psalm-param T $left
                     */
                    static fn ($left): Closure =>
                        /**
                         * @psalm-param T $right
                         */
                        static fn ($right): bool => $left === $right;

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, bool> $matchOne */
                $matchOne = MatchOne::of()(static fn (): bool => true)(...array_map($callback, $values));

                // Point free style.
                return $matchOne;
            };
    }
}
