<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class IfThenElse extends AbstractOperation implements Operation
{
    // phpcs:disable
    /**
     * @psalm-return Closure(callable(T, TKey): bool): Closure(callable(T, TKey): (T|TKey)): Closure(callable(T, TKey): (T|TKey)): Generator<TKey, T>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey): bool $condition
             */
            static function (callable $condition): Closure {
                return
                    /**
                     * @psalm-param callable(T, TKey): (T|TKey) $then
                     */
                    static function (callable $then) use ($condition): Closure {
                        return
                            /**
                             * @psalm-param callable(T, TKey): (T|TKey) $else
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
