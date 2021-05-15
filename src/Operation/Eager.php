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

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Eager extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Iterator<TKey, T>
             */
            static function (Iterator $iterator): Iterator {
                // As keys can be of any type in this library.We cannot use
                // iterator_to_array() because it expect keys to be int|string.
                foreach (new IterableIterator($iterator) as $key => $value) {
                }

                return $iterator;
            };
    }
}
