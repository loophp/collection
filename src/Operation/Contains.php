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
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Contains extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(T ...$values): Closure(Iterator<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$values
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, bool>
             */
            static function (...$values): Closure {
                $callback =
                    /**
                     * @param T $left
                     */
                    static fn ($left): Closure =>
                        /**
                         * @param T $right
                         */
                        static fn ($right): bool => $left === $right;

                /** @var Closure(Iterator<TKey, T>): Generator<TKey, bool> $matchOne */
                $matchOne = MatchOne::of()(static fn (): bool => true)(...array_map($callback, $values));

                // Point free style.
                return $matchOne;
            };
    }
}
