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
final class Has extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (callable $callback): Closure {
                $matcher =
                    /**
                     * @psalm-param T $value
                     * @psalm-return T
                     */
                    static fn ($value) => $value;

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, bool> $match */
                $match = Match::of()($matcher)($callback);

                // Point free style.
                return $match;
            };
    }
}
