<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use LimitIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Drop extends AbstractOperation
{
    /**
     * @psalm-return Closure(int...): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (int ...$offsets): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Iterator<TKey, T>
                 */
                static function (Iterator $iterator) use ($offsets): Iterator {
                    return new LimitIterator($iterator, array_sum($offsets));
                };
    }
}
