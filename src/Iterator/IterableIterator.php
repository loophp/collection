<?php

declare(strict_types=1);

namespace drupol\collection\Iterator;

use Generator;
use Iterator;

/**
 * Class IterableIterator.
 *
 * @implements Iterator<Iterator>
 */
final class IterableIterator implements Iterator
{
    /**
     * @var \drupol\collection\Iterator\ClosureIterator
     */
    private $iterator;

    /**
     * IterableIterator constructor.
     *
     * @param iterable<mixed> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            static function () use ($iterable): Generator {
                foreach ($iterable as $key => $value) {
                    yield $key => $value;
                }
            }
        );
    }

    /**
     * @return Iterator<mixed>
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * {@inheritdoc}
     *
     * @return int|string
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function next()
    {
        $this->iterator->next();

        return $this;
    }

    /**
     * @return $this|void
     */
    public function rewind()
    {
        $this->iterator->rewind();

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function valid()
    {
        return $this->iterator->valid();
    }
}
