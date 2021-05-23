<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use LimitIterator;

/**
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Limit extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(int): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(int): Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (int $count = -1): Closure =>
                /**
                 * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
                 */
                static fn (int $offset = 0): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @return Iterator<TKey, T>
                     */
                    static fn (Iterator $iterator): Iterator => new LimitIterator($iterator, $offset, $count);
    }
}
