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
final class Span extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey , Iterator<TKey, T> ): bool):Closure (Iterator<TKey, T>): Generator<int, Iterator<TKey, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>):bool $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, Iterator<TKey, T>>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<int, Iterator<TKey, T>>
                 */
                static function (Iterator $iterator) use ($callback): Generator {
                    /** @psalm-var Iterator<TKey, T> $takeWhile */
                    $takeWhile = TakeWhile::of()($callback)($iterator);
                    /** @psalm-var Iterator<TKey, T> $dropWhile */
                    $dropWhile = DropWhile::of()($callback)($iterator);

                    return yield from [$takeWhile, $dropWhile];
                };
    }
}
