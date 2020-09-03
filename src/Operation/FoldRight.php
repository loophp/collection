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
final class FoldRight extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T|null, T, TKey, Iterator<TKey, T>): T): Closure(T|null): Closure(Iterator<TKey, T>): T|null
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey, Iterator<TKey, T>): T $callback
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @param mixed|null $initial
                     * @psalm-param T|null $initial
                     */
                    static function ($initial = null) use ($callback): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<int, T|null>
                             */
                            static function (Iterator $iterator) use ($callback, $initial): Generator {
                                /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $foldRight */
                                $foldRight = Compose::of()(
                                    Reverse::of(),
                                    FoldLeft::of()($callback)($initial)
                                );

                                return yield from $foldRight($iterator);
                            };
                    };
            };
    }
}
