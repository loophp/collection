<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\NormalizeIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Normalize extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, T>
             */
            static fn (iterable $iterable): Generator => yield from new NormalizeIterableAggregate($iterable);
    }
}
