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
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Since extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey ): bool ...):Closure (Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey):bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $reducerCallback =
                        /**
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $current
                             * @psalm-param T $current
                             *
                             * @psalm-return Closure(Iterator<TKey, T>): Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                             */
                            static fn ($current): Closure =>
                                /**
                                 * @psalm-param Iterator<TKey, T> $iterator
                                 *
                                 * @psalm-return Closure(bool, callable(T, TKey, Iterator<TKey, T>): bool): bool
                                 */
                                static fn (Iterator $iterator): Closure =>
                                    /**
                                     * @psalm-param bool $carry
                                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callable
                                     */
                                    static fn (bool $carry, callable $callable): bool => ($callable($current, $key, $iterator)) ? $carry : false;

                    for (; $iterator->valid(); $iterator->next()) {
                        $key = $iterator->key();
                        $current = $iterator->current();

                        $result = array_reduce(
                            $callbacks,
                            $reducerCallback($key)($current)($iterator),
                            true
                        );

                        if (false !== $result) {
                            break;
                        }
                    }

                    for (; $iterator->valid(); $iterator->next()) {
                        yield $iterator->key() => $iterator->current();
                    }
                };
    }
}
