<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
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
final class Associate extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey , T , Iterator<TKey, T> ): (T | TKey) ...):Closure ((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) ...$callbackForKeys
             *
             * @psalm-return Closure((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
             */
            static fn (callable ...$callbackForKeys): Closure =>
                /**
                 * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) ...$callbackForValues
                 *
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
                 */
                static fn (callable ...$callbackForValues): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey|T, T|TKey>
                     */
                    static function (Iterator $iterator) use ($callbackForKeys, $callbackForValues): Generator {
                        $callbackFactory =
                            /**
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @psalm-return Closure(T): Closure(T, callable(T, TKey, T, Iterator<TKey, T>): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                             */
                            static fn ($key): Closure =>
                                /**
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 *
                                 * @psalm-return Closure(T, callable(T, TKey, T, Iterator<TKey, T>): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                                 */
                                static fn ($value): Closure =>
                                    /**
                                     * @param mixed $initial
                                     * @psalm-param T $initial
                                     * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) $callback
                                     * @psalm-param Iterator<TKey, T> $iterator
                                     *
                                     * @psalm-return T|TKey
                                     */
                                    static fn ($initial, callable $callback, int $callbackId, Iterator $iterator) => $callback($initial, $key, $value, $iterator);

                        for (; $iterator->valid(); $iterator->next()) {
                            $key = $iterator->key();
                            $current = $iterator->current();

                            /** @psalm-var Generator<int, TKey|T> $k */
                            $k = FoldLeft::of()($callbackFactory($key)($current))($key)(new ArrayIterator($callbackForKeys));

                            /** @psalm-var Generator<int, T|TKey> $c */
                            $c = FoldLeft::of()($callbackFactory($key)($current))($current)(new ArrayIterator($callbackForValues));

                            yield $k->current() => $c->current();
                        }
                    };
    }
}
