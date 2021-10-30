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
     * @return Closure(bool): Closure(Iterator<TKey, T>): list<T>|array<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): list<T>|array<TKey, T>
             */
            static fn (bool $normalize): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return array<TKey, T>|list<T>
                 */
                static fn (Iterator $iterator): array => $normalize
                    ? iterator_to_array((new Normalize())()($iterator))
                    : iterator_to_array($iterator);
    }
}
