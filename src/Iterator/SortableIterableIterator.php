<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use IteratorAggregate;

/**
 * Class SortableIterableIterator.
 *
 * @implements IteratorAggregate<ArrayIterator>
 */
final class SortableIterableIterator implements IteratorAggregate
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var \loophp\collection\Iterator\IterableIterator
     */
    private $iterator;

    /**
     * SortableIterator constructor.
     *
     * @param iterable<mixed> $iterable
     * @param callable $callable
     */
    public function __construct(iterable $iterable, callable $callable)
    {
        $this->callable = $callable;
        $this->iterator = new IterableIterator($iterable);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $arrayIterator = new ArrayIterator(iterator_to_array($this->iterator));

        $arrayIterator->uasort($this->callable);

        return $arrayIterator;
    }
}
