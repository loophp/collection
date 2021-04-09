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
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>...): bool): Closure(callable(T, TKey, Iterator<TKey, T>...): bool): Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$matchers
             *
             * @psalm-return Closure(...callable(T, TKey, Iterator<TKey, T>): bool): Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
             */
            static function (callable ...$matchers): Closure {
                return
                    /**
                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
                     */
                    static function (callable ...$callbacks) use ($matchers): Closure {
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
                                    static fn (bool $carry, callable $callback): bool => $carry || $callback($value, $key, $iterator),
                                    false
                                );

                        $mapCallback =
                            /**
                             * @psalm-param callable(T, TKey, Iterator<TKey, T>) $reducer1
                             *
                             * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>)): Closure(T, TKey, Iterator<TKey, T>): bool
                             */
                            static fn (callable $reducer1): Closure =>
                                /**
                                 * @psalm-param callable(T, TKey, Iterator<TKey, T>) $reducer2
                                 *
                                 * @psalm-return Closure(T, TKey, Iterator<TKey, T>): bool
                                 */
                                static fn (callable $reducer2): Closure =>
                                    /**
                                     * @param mixed $value
                                     * @psalm-param T $value
                                     *
                                     * @param mixed $key
                                     * @psalm-param TKey $key
                                     *
                                     * @psalm-param Iterator<TKey, T> $iterator
                                     */
                                    static fn ($value, $key, Iterator $iterator): bool => $reducer1($value, $key, $iterator) !== $reducer2($value, $key, $iterator);

                        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey|int, bool> $pipe */
                        $pipe = Pipe::of()(
                            Map::of()($mapCallback($callbackReducer($callbacks))($callbackReducer($matchers))),
                            DropWhile::of()(static fn (bool $value): bool => true === $value),
                            Append::of()(true),
                            Head::of(),
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
