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
final class All
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): array<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return array<TKey, T>
             */
            static fn (Iterator $iterator): array => iterator_to_array($iterator);
    }
}
