<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use InfiniteIterator;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Cycle extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Iterator<TKey, T>
             */
            static fn (Iterator $iterator): Iterator => new InfiniteIterator($iterator);
    }
}
