<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Zip extends AbstractOperation
{
    /**
     * @psalm-return Closure(iterable<TKey, T>...): Closure(Iterator<TKey, T>): Iterator<list<TKey>, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param iterable<TKey, T> ...$iterables
             *
             * @psalm-return Closure(Iterator<TKey, T>): Iterator<list<TKey>, list<T>>
             */
            static fn (iterable ...$iterables): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T>: Iterator<list<TKey>, list<T>>
                 *
                 * @psalm-return Iterator<list<TKey>, list<T>>
                 */
                static function (Iterator $iterator) use ($iterables): Iterator {
                    $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);
                    $mit->attachIterator($iterator);

                    foreach ($iterables as $iterableIterator) {
                        $mit->attachIterator(new IterableIterator($iterableIterator));
                    }

                    return $mit;
                };
    }
}
