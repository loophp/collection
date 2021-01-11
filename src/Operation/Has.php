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
 */
final class Has extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T ...): Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
             */
            static function (callable ...$callbacks): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int|TKey, bool>
                     */
                    static function (Iterator $iterator) use ($callbacks): Generator {
                        /** @psalm-var list<Closure(T, TKey, Iterator<TKey, T>): bool> $callbacks */
                        $callbacks = array_map(
                            /**
                             * @psalm-param callable(T, TKey, Iterator<TKey, T>): bool $callback
                             */
                            static fn (callable $callback): Closure =>
                                /**
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 *
                                 * @param mixed $key
                                 * @psalm-param TKey $key
                                 *
                                 * @psalm-param Iterator<TKey, T> $iterator
                                 */
                                static fn ($value, $key, Iterator $iterator): bool => $callback($value, $key, $iterator) === $value,
                            $callbacks
                        );

                        foreach ($iterator as $key => $current) {
                            /** @psalm-var Iterator<int, bool> $result */
                            $result = MatchOne::of()(static fn () => true)(...$callbacks)(Pair::of()(new ArrayIterator([$key, $current])));

                            if (true === $result->current()) {
                                return yield $key => true;
                            }
                        }

                        return yield false;
                    };
            };
    }
}
