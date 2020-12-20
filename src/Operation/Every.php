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
final class Every extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T> ): bool):Closure (Iterator<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, bool>
             */
            static function (callable $callback): Closure {
                $callbackBuilder =
                    /**
                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callback
                     */
                    static fn (callable $callback): Closure =>
                        /**
                         * @param mixed $carry
                         * @psalm-param T $carry
                         *
                         * @param mixed $value
                         * @psalm-param T $value
                         *
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-param Iterator<TKey, T> $iterator
                         */
                        static fn ($carry, $value, $key, Iterator $iterator): bool => $callback($value, $key, $iterator);

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, bool> $foldLeft */
                $foldLeft = FoldLeft::of()($callbackBuilder($callback))(true);

                // Point free style.
                return $foldLeft;
            };
    }
}
