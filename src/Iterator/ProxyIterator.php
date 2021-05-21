<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Iterator;
use OuterIterator;

/**
 * @internal
 *
 * @psalm-template TKey
 * @psalm-template T
 *
 * @implements OuterIterator<TKey, T>
 */
abstract class ProxyIterator implements OuterIterator
{
    /**
     * @psalm-var Iterator<TKey, T>
     */
    protected Iterator $iterator;

    /**
     * @return mixed
     * @psalm-return T
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @psalm-return Iterator<TKey, T>
     */
    public function getInnerIterator(): Iterator
    {
        return $this->iterator;
    }

    /**
     * @psalm-return TKey
     */
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
