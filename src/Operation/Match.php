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
final class Match extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T): Closure(callable(T, TKey, Iterator<TKey, T>): T): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T $matcher
             *
             * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T): Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (callable $matcher): Closure {
                return
                    /**
                     * @psalm-param callable(T, TKey, Iterator<TKey, T>): T $callback
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
                     */
                    static function (callable $callback) use ($matcher): Closure {
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
                            static fn ($value, $key, Iterator $iterator): bool => $matcher($value, $key, $iterator) === $callback($value, $key, $iterator);

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
