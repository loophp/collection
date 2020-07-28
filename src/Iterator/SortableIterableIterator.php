<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use ArrayIterator;
use IteratorAggregate;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements IteratorAggregate<ArrayIterator<TKey, T>>
 */
final class SortableIterableIterator implements IteratorAggregate
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var \loophp\collection\Iterator\IterableIterator<TKey, T>
     */
    private $iterator;

    /**
     * SortableIterableIterator constructor.
     *
     * @param iterable<TKey, T> $iterable
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
