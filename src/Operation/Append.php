<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Iterator\MultipleIterableIterator;

/**
 * @template TKey
 * @template T
 */
final class Append extends AbstractOperation
{
    /**
     * @return Closure(mixed ...$items): Closure(Iterator<TKey, T>): Iterator<int|TKey, T|mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed ...$items
             *
             * @return Closure(Iterator<TKey, T>): Iterator<int|TKey, T|mixed>
             */
            static fn (...$items): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Iterator<int|TKey, mixed|T>
                 */
                static fn (Iterator $iterator): Iterator => new MultipleIterableIterator($iterator, $items);
    }
}
