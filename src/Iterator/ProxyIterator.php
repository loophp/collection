<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;

abstract class ProxyIterator
{
    /**
     * @var Generator<mixed>|\loophp\collection\Iterator\ClosureIterator
     */
    protected $iterator;

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @return Iterator<mixed>
     */
    public function getInnerIterator(): Iterator
    {
        return $this->iterator;
    }

    /**
     * @return mixed
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
