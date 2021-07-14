<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use AppendIterator;
use NoRewindIterator;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class MultipleIterableIterator extends ProxyIterator
{
    /**
     * @param iterable<TKey, T> $iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $appendIterator = new AppendIterator();

        foreach ($iterables as $iterable) {
            $appendIterator->append(new NoRewindIterator(new IterableIterator($iterable)));
        }

        $this->iterator = $appendIterator;
    }
}
