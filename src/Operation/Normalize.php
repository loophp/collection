<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\iterators\NormalizeIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Normalize extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, T>
             */
            static fn (Iterator $iterator): Generator => yield from new NormalizeIteratorAggregate($iterator);
    }
}
