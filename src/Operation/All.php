<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class All extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(bool): Closure(Iterator<TKey, T>): Iterator<int, T>|Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Iterator<int, T>|Iterator<TKey, T>
             */
            static fn (bool $normalize): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Iterator<int, T>|Iterator<TKey, T>
                 */
                static fn (Iterator $iterator): Iterator => $normalize ? (new Normalize())()($iterator) : $iterator;
    }
}
