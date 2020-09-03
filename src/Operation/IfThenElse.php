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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class IfThenElse extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey): bool): Closure(callable(T, TKey): (T)): Closure(callable(T, TKey): (T)): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey): bool $condition
             *
             * @psalm-return Closure(callable(T, TKey): (T)): Closure(callable(T, TKey): (T)): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable $condition): Closure {
                return
                    /**
                     * @psalm-param callable(T, TKey): (T) $then
                     *
                     * @psalm-return Closure(callable(T, TKey): (T)): Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (callable $then) use ($condition): Closure {
                        return
                            /**
                             * @psalm-param callable(T, TKey): (T) $else
                             *
                             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                             */
                            static function (callable $else) use ($condition, $then): Closure {
                                return
                                    /**
                                     * @psalm-param Iterator<TKey, T> $iterator
                                     *
                                     * @psalm-return Generator<TKey, T>
                                     */
                                    static function (Iterator $iterator) use ($condition, $then, $else): Generator {
                                        foreach ($iterator as $key => $value) {
                                            yield $key => $condition($value, $key) ?
                                                $then($value, $key) :
                                                $else($value, $key);
                                        }
                                    };
                            };
                    };
            };
    }
}
