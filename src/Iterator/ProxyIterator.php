<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
abstract class ProxyIterator
{
    /**
     * @var Generator<TKey, bool|float|int|string|T>|\loophp\collection\Iterator\ClosureIterator
     */
    protected $iterator;

    /**
     * @return bool|float|int|string|T
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @return Iterator<TKey, T>
     */
    public function getInnerIterator(): Iterator
    {
        return $this->iterator;
    }

    /**
     * @return TKey
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
