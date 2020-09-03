<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
abstract class ProxyIterator
{
    /**
     * @psalm-var Generator<TKey, T>|Iterator<TKey, T>
     */
    protected $iterator;

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
