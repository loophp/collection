<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use AppendIterator;
use Iterator;
use loophp\iterators\IterableIterator;
use NoRewindIterator;
use ReturnTypeWillChange;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @implements Iterator<TKey, T>
 */
final class MultipleIterableIterator implements Iterator
{
    /**
     * @var Iterator<TKey, T>
     */
    private Iterator $iterator;

    /**
     * @param iterable<TKey, T> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $appendIterator = new AppendIterator();

        foreach ($iterables as $iterable) {
            $appendIterator->append(new NoRewindIterator(new IterableIterator($iterable)));
        }

        $this->iterator = $appendIterator;
    }

    /**
     * @return T
     */
    #[ReturnTypeWillChange]
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @return TKey
     */
    #[ReturnTypeWillChange]
    public function key()
    {
        return $this->iterator->key();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }
}
