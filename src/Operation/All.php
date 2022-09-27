<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class All extends AbstractOperation
{
    /**
     * @return Closure(bool): Closure(iterable<TKey, T>): (Generator<int, T>|Generator<TKey, T>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): ($normalize is true ? Generator<int, T> : Generator<TKey, T>)
             */
            static fn (bool $normalize): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int, T>|Generator<TKey, T>
                 */
                static fn (iterable $iterable): Generator => yield from ($normalize ? (new Normalize())()($iterable) : $iterable);
    }
}
