<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function call_user_func_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class MatchOne extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T): Closure(callable(T, TKey, Iterator<TKey, T>): bool): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T $matcher
             *
             * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): bool): Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (callable $matcher): Closure {
                return
                    /**
                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
                     */
                    static function (callable ...$callbacks) use ($matcher): Closure {
                        $callbackReducer =
                            /**
                             * @psalm-param list<callable(T, TKey, Iterator<TKey, T>): bool> $callbacks
                             *
                             * @psalm-return Closure(T, TKey, Iterator<TKey, T>): bool
                             */
                            static fn (array $callbacks): Closure =>
                                /**
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 *
                                 * @param mixed $key
                                 * @psalm-param TKey $key
                                 *
                                 * @psalm-param Iterator<TKey, T> $iterator
                                 */
                                static fn ($value, $key, Iterator $iterator): bool => array_reduce(
                                    $callbacks,
                                    static fn (bool $carry, callable $callback): bool => $carry || call_user_func_array($callback, [$value, $key, $iterator]),
                                    false
                                );

                        $callback = $callbackReducer($callbacks);

                        $mapCallback =
                            /**
                             * @param mixed $value
                             * @psalm-param T $value
                             *
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @psalm-param Iterator<TKey, T> $iterator
                             */
                            static fn ($value, $key, Iterator $iterator): bool => call_user_func_array($matcher, [$value, $key, $iterator]) === call_user_func_array($callback, [$value, $key, $iterator]);

                        $dropWhileCallback =
                            /**
                             * @param mixed $value
                             * @psalm-param T $value
                             */
                            static fn ($value): bool => !(bool) $value;

                        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
                        $pipe = Pipe::of()(
                            Map::of()($mapCallback),
                            DropWhile::of()($dropWhileCallback),
                            Append::of()(false),
                            Head::of()
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
