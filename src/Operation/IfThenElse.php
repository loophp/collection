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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class IfThenElse extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey): bool): Closure(callable(T, TKey): (T)): Closure(callable(T, TKey): (T)): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey):bool $condition
             *
             * @return Closure(callable(T, TKey): (T)): Closure(callable(T, TKey): (T)): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $condition): Closure =>
                /**
                 * @psalm-param callable(T, TKey):T $then
                 *
                 * @return Closure(callable(T, TKey): (T)): Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static fn (callable $then): Closure =>
                    /**
                     * @psalm-param callable(T, TKey):T $else
                     *
                     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (callable $else) use ($condition, $then): Closure {
                        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $map */
                        $map = Map::of()(
                            /**
                             * @param mixed $value
                             * @psalm-param T $value
                             *
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @return T
                             */
                            static fn ($value, $key, Iterator $iterator) => $condition($value, $key, $iterator) ? $then($value, $key, $iterator) : $else($value, $key, $iterator)
                        );

                        // Point free style.
                        return $map;
                    };
    }
}
