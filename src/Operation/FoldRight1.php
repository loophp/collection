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
final class FoldRight1 extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T|null, T, TKey, Iterator<TKey, T>):(T|null)): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callback): Generator {
                        /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $foldRight1 */
                        $foldRight1 = Compose::of()(
                            Reverse::of(),
                            FoldLeft1::of()($callback)
                        );

                        return yield from $foldRight1($iterator);
                    };
            };
    }
}
