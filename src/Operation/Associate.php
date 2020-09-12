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
     * @psalm-return Closure((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) ...$callbackForKeys
             *
             * @psalm-return Closure((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
             */
            static function (callable ...$callbackForKeys): Closure {
                return
                    /**
                     * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) ...$callbackForValues
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
                     */
                    static function (callable ...$callbackForValues) use ($callbackForKeys): Closure {
                        return
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
                                    static function ($key): Closure {
                                        return
                                            /**
                                             * @param mixed $value
                                             * @psalm-param T $value
                                             *
                                             * @psalm-return Closure(T, callable(T, TKey, T, Iterator<TKey, T>): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                                             */
                                            static function ($value) use ($key): Closure {
                                                return
                                                    /**
                                                     * @param mixed $initial
                                                     * @psalm-param T $initial
                                                     * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) $callback
                                                     * @psalm-param Iterator<TKey, T> $iterator
                                                     *
                                                     * @psalm-return T|TKey
                                                     */
                                                    static function ($initial, callable $callback, int $callbackId, Iterator $iterator) use ($key, $value) {
                                                        return $callback($initial, $key, $value, $iterator);
                                                    };
                                            };
                                    };

                                foreach ($iterator as $key => $value) {
                                    /** @psalm-var Generator<int, TKey|T> $k */
                                    $k = FoldLeft::of()($callbackFactory($key)($value))($key)(new ArrayIterator($callbackForKeys));

                                    /** @psalm-var Generator<int, T|TKey> $c */
                                    $c = FoldLeft::of()($callbackFactory($key)($value))($value)(new ArrayIterator($callbackForValues));

                                    yield $k->current() => $c->current();
                                }
                            };
                    };
            };
    }
}
