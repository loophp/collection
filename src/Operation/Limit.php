<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use LimitIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Limit extends AbstractOperation
{
    /**
     * @psalm-return Closure(int  = default):Closure (int=): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(int=): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (int $count = -1): Closure =>
                /**
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static fn (int $offset = 0): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static fn (Iterator $iterator): Generator => yield from new LimitIterator($iterator, $offset, $count);
    }
}
