<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Contains extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$values
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
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
                $matchOne = MatchOne::of()(static fn () => true)(...array_map($callback, $values));

                // Point free style.
                return $matchOne;
            };
    }
}
