<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class IterableIterator extends ProxyIterator
{
    /**
     * @param iterable<TKey, T> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            static fn (iterable $iterable): Generator => yield from $iterable,
            [$iterable]
        );
    }
}
