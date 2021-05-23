<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Zip extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>...): Closure(Iterator<TKey, T>): Iterator<list<TKey>, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> ...$iterables
             *
             * @return Closure(Iterator<TKey, T>): Iterator<list<TKey>, list<T>>
             */
            static fn (iterable ...$iterables): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Iterator<list<TKey>, list<T>>
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
